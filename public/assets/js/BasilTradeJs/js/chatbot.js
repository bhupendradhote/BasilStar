$(document).ready(function () {
    // --- DOM Elements ---
    const chatbox = $('#chatbox');
    const stockSelector = $('#stockSelectorChat');

    // --- Helper Calculation Functions ---
    // (These are basic implementations. Use more robust libraries or custom functions if needed)

    function calculateSimpleMA(prices, period) {
        if (!prices || !Array.isArray(prices) || prices.length < period) return null;
        // Ensure we only use valid numbers
        const validPrices = prices.filter(p => typeof p === 'number' && !isNaN(p));
        if (validPrices.length < period) return null;
        const relevantPrices = validPrices.slice(-period);
        const sum = relevantPrices.reduce((acc, price) => acc + price, 0);
        return sum / period;
    }

    function getPriceVsMaStatus(price, ma) {
        if (ma === null || price === null || isNaN(price) || isNaN(ma)) return "N/A";
        const tolerance = 0.001; // 0.1% tolerance
        if (price > ma * (1 + tolerance)) return '<span class="text-success">Buy</span>'; // Using text-success for buy
        if (price < ma * (1 - tolerance)) return '<span class="text-danger">Sell</span>'; // Using text-danger for sell
        return "Near (Neutral)";
    }

    function calculateChange(prices, period) {
        if (!prices || !Array.isArray(prices) || prices.length < period + 1) return 0; // Changed from NaN to 0
        // Get latest valid prices
        const validPrices = prices.filter(p => typeof p === 'number' && !isNaN(p));
        if (validPrices.length < period + 1) return 0; // Changed from NaN to 0
        const currentPrice = validPrices[validPrices.length - 1];
        const pastPrice = validPrices[validPrices.length - 1 - period];
        if (pastPrice === 0) return 0; // Avoid division by zero
        if (isNaN(currentPrice) || isNaN(pastPrice)) return 0; // Changed from NaN to 0

        return ((currentPrice - pastPrice) / pastPrice) * 100; // Return percentage change
    }

    function generateReturnDescription(prices, period) {
        if (!prices || !Array.isArray(prices) || prices.length <= period) return "N/A";
        const validPrices = prices.filter(p => typeof p === 'number' && !isNaN(p));
         if (validPrices.length <= period) return "N/A";

        const currentPrice = validPrices[validPrices.length - 1];
        const pastPrice = validPrices[validPrices.length - 1 - period];
        if (isNaN(currentPrice) || isNaN(pastPrice)) return "N/A";

        const change = currentPrice - pastPrice;
        const percentChange = pastPrice === 0 ? 0 : (change / pastPrice) * 100;

        let desc = `${percentChange >= 0 ? '+' : ''}${percentChange.toFixed(2)}%`;
        if (percentChange > 0) return `<span class="text-success">${desc}</span>`;
        if (percentChange < 0) return `<span class="text-danger">${desc}</span>`;
        return desc; // Return neutral if 0% change
    }

    function getSentimentStatus(changePercent) {
        // Returns HTML string
        if (isNaN(changePercent)) return '<span style="color: #6b7280;">N/A</span>'; // Handle NaN
        // Adjusted thresholds for sentiment description
        if (changePercent > 1.5) return '<span style="color: #16a34a; font-weight: bold;">Strong Buy</span>'; // Stronger green
        if (changePercent > 0.2) return '<span style="color: #22c55e;">Buy</span>'; // Green
        if (changePercent < -1.5) return '<span style="color: #dc2626; font-weight: bold;">Strong Sell</span>'; // Stronger red
        if (changePercent < -0.2) return '<span style="color: #f43f5e;">Sell</span>'; // Red
        return '<span style="color: #6b7280;">Neutral</span>'; // Gray
    }

    // REMOVED the local calculatePivotPointsSimple function from here.
    // It is now assumed that getPivotCalculations is available globally from pivotCalculations.js

    // --- End of Helper Functions ---


    // --- Data Processing Function ---
/**
 * Processes stock data received from the Twelve Data API for reporting.
 * @param {object} stockDataJson - The raw JSON response object from the Twelve Data API.
 * @returns {object|null} A processed object with calculated metrics, or null on error.
 */
function processStockDataForReport(stockDataJson) {
    // 1. Validate the input structure (Twelve Data format)
    if (!stockDataJson || stockDataJson.status !== 'ok' || !Array.isArray(stockDataJson.values) || stockDataJson.values.length === 0) {
        console.error("Invalid or missing 'values' array or non-'ok' status in Twelve Data JSON.", stockDataJson);
        return null;
    }

    // 2. Extract and prepare data (reverse for chronological order)
    const timeSeriesData = stockDataJson.values.slice().reverse(); // Newest first -> Oldest first

    // Extract arrays, ensuring they contain valid numbers
    const dates = timeSeriesData.map(item => item.datetime);
    const closingPrices = timeSeriesData.map(item => parseFloat(item.close)).filter(p => typeof p === 'number' && !isNaN(p));
    const highPrices = timeSeriesData.map(item => parseFloat(item.high)).filter(p => typeof p === 'number' && !isNaN(p));
    const lowPrices = timeSeriesData.map(item => parseFloat(item.low)).filter(p => typeof p === 'number' && !isNaN(p));
    const openPrices = timeSeriesData.map(item => parseFloat(item.open)).filter(p => typeof p === 'number' && !isNaN(p)); // Added open prices
    // Note: If filtering removes entries, the array lengths might mismatch the original dates length slightly if data was bad.
    // Calculations generally rely on price arrays, so this filtering is usually safer.

    if (dates.length === 0) {
         console.error("No dates could be extracted from time series data.");
         return null;
     }
    if (closingPrices.length === 0) {
        console.error("No valid closing prices could be extracted.");
        return null;
    }

    // 3. Get Latest Data Point details
    // Ensure we have enough data points for the latest calculation and potentially pivots
    if (timeSeriesData.length < 2) { // Need at least 2 days for daily change, and often pivots
        console.error("Not enough historical data points received for analysis (need at least 2).");
        return null;
    }

    const latestDataPoint = timeSeriesData[timeSeriesData.length - 1];
    const secondLatestDataPoint = timeSeriesData[timeSeriesData.length - 2]; // Needed for daily change

    if (!latestDataPoint || !secondLatestDataPoint) {
         console.error(`Could not get the latest or second latest data point from the time series.`);
         return null;
     }

    let processed = {};

    // 4. Latest Price Info (handle potential NaN and missing volume)
    processed.latest = {
        date: latestDataPoint.datetime,
        open: parseFloat(latestDataPoint.open),
        high: parseFloat(latestDataPoint.high),
        low: parseFloat(latestDataPoint.low),
        close: parseFloat(latestDataPoint.close),
        // Volume might not always be present depending on the API plan/response
        volume: latestDataPoint.volume ? parseInt(latestDataPoint.volume, 10) : 0
    };

    // Check if latest HLOC are valid, crucial for subsequent calculations like pivots
     if (isNaN(processed.latest.high) || isNaN(processed.latest.low) || isNaN(processed.latest.close) || isNaN(processed.latest.open)) {
         console.error(`Invalid HLOC data for the latest date (${processed.latest.date}): H=${processed.latest.high}, L=${processed.latest.low}, C=${processed.latest.close}, O=${processed.latest.open}. Cannot calculate pivots or daily change reliably.`);
         return null; // Cannot calculate pivots or daily change reliably
     }


    // 5. Daily Change (Uses the extracted latest and second latest data points)
    const currentClose = processed.latest.close;
    const previousClose = parseFloat(secondLatestDataPoint.close);

    if (!isNaN(currentClose) && !isNaN(previousClose)) {
        processed.dailyChange = currentClose - previousClose;
        // Prevent division by zero
        processed.dailyChangePercent = previousClose === 0 ? 0 : ((processed.dailyChange / previousClose) * 100);
    } else {
        processed.dailyChange = NaN; // Use NaN if calculation fails
        processed.dailyChangePercent = NaN; // Use NaN if calculation fails
         console.warn("Could not calculate daily change due to invalid latest or previous close price.");
    }


    // 6. Moving Averages (Uses the filtered closingPrices array)
    // Ensure helper functions (calculateSimpleMA, getPriceVsMaStatus) exist and work correctly.
    processed.movingAverages = {
        ma20: calculateSimpleMA(closingPrices, 20),
        ma50: calculateSimpleMA(closingPrices, 50),
        ma100: calculateSimpleMA(closingPrices, 100),
        ma200: calculateSimpleMA(closingPrices, 200)
    };
    processed.movingAveragesStatus = {
        ma20: getPriceVsMaStatus(processed.latest.close, processed.movingAverages.ma20),
        ma50: getPriceVsMaStatus(processed.latest.close, processed.movingAverages.ma50),
        ma100: getPriceVsMaStatus(processed.latest.close, processed.movingAverages.ma100),
        ma200: getPriceVsMaStatus(processed.latest.close, processed.movingAverages.ma200)
    };

    // 7. Returns Analysis (Uses the filtered closingPrices array)
     // Ensure helper function (generateReturnDescription) exists and works correctly.
    processed.returns = {
        daily: generateReturnDescription(closingPrices, 1),
        weekly: generateReturnDescription(closingPrices, 5),   // 5 trading days/week
        monthly: generateReturnDescription(closingPrices, 21),  // ~21 trading days/month
        yearly: generateReturnDescription(closingPrices, 252) // ~252 trading days/year
    };

    // 8. Sentiment (Uses the calculated daily change percent)
    // Ensure helper functions (calculateChange, getSentimentStatus) exist and work correctly.
     // Use the dailyChangePercent calculated earlier for 1D sentiment
    processed.sentiment = {
        '1D': getSentimentStatus(processed.dailyChangePercent),
        '1W': getSentimentStatus(calculateChange(closingPrices, 5)),
        '1M': getSentimentStatus(calculateChange(closingPrices, 21)),
        '3M': getSentimentStatus(calculateChange(closingPrices, 63)) // ~63 trading days/quarter
    };

    // 9. Pivot Points (Using latest valid HLOC)
    // Check if getPivotCalculations function exists (from pivotCalculations.js)
    if (typeof getPivotCalculations === 'function') {
         console.log("getPivotCalculations function found. Calculating pivots with:", processed.latest); // Log data before calculation
         processed.pivotPoints = getPivotCalculations(
             processed.latest.high,
             processed.latest.low,
             processed.latest.close,
             processed.latest.open // Pass open price as required by getPivotCalculations
         );
         // Add a check after calculation for Classic PP
         if (!processed.pivotPoints || !processed.pivotPoints.classic || isNaN(parseFloat(processed.pivotPoints.classic.P))) { // Check for 'P' property which is PP
             console.error("Pivot calculation completed, but Classic PP is invalid.", processed.pivotPoints);
             // Assign N/A values if Classic PP is still bad
             processed.pivotPoints = {
                 classic: { R3: 'N/A', R2: 'N/A', R1: 'N/A', P: 'N/A', S1: 'N/A', S2: 'N/A', S3: 'N/A' },
                 fibonacci: null, // Set to null or N/A structure if invalid
                 camarilla: null, // Set to null or N/A structure if invalid
                 woodie: null,    // Set to null or N/A structure if invalid
                 demark: null     // Set to null or N/A structure if invalid
             };
         }
     } else {
         console.error("getPivotCalculations function is not available. Make sure pivotCalculations.js is loaded before chatbot.js.");
         // Assign a structure that the reporting function expects, but with N/A values
         processed.pivotPoints = {
             classic: { R3: 'N/A', R2: 'N/A', R1: 'N/A', P: 'N/A', S1: 'N/A', S2: 'N/A', S3: 'N/A' }, // Use 'P' for Classic PP
             fibonacci: null,
             camarilla: null,
             woodie: null,
             demark: null
         };
     }


    // 10. Momentum Oscillators (Uses filtered price arrays)
    // Ensure the function `calculateMomentumOscillators` exists (loaded from oscillatorAnalysis.js)
    let momentumResult = typeof calculateMomentumOscillators === 'function'
                         ? calculateMomentumOscillators(closingPrices, highPrices, lowPrices)
                         : { buy: 0, sell: 0, neutral: 0 }; // Default placeholder if function not found
    processed.momentumSummary = {
        buy: momentumResult?.buy || 0, // Use optional chaining for safety
        sell: momentumResult?.sell || 0, // Use optional chaining for safety
        neutral: momentumResult?.neutral || 0 // Use optional chaining for safety
    };
    if(typeof calculateMomentumOscillators !== 'function') console.warn("calculateMomentumOscillators function not found. Momentum summary may be incomplete. Ensure oscillatorAnalysis.js is loaded.");


    // 11. Trend Oscillators (Uses filtered price arrays)
    // IMPORTANT: You need to ensure calculateTrendOscillators is defined globally or included.
     // Assuming calculateTrendOscillators is in a separate file and loaded before this script
    let trendResult = typeof calculateTrendOscillators === 'function'
                      ? calculateTrendOscillators(closingPrices, highPrices, lowPrices)
                      : { buy: 0, sell: 0, neutral: 0 }; // Default placeholder if function not found
    processed.trendSummary = {
        buy: trendResult?.buy || 0, // Use optional chaining for safety
        sell: trendResult?.sell || 0, // Use optional chaining for safety
        neutral: trendResult?.neutral || 0 // Use optional chaining for safety
    };
     if(typeof calculateTrendOscillators !== 'function') console.warn("calculateTrendOscillators function not found. Trend summary may be incomplete.");


    // 12. Technical Analysis Summary (Based on calculated statuses)
    processed.technicalSummary = {
        maBuy: Object.values(processed.movingAveragesStatus).filter(s => s && s.includes('Buy')).length, // Added check for s existence
        maSell: Object.values(processed.movingAveragesStatus).filter(s => s && s.includes('Sell')).length, // Added check for s existence
        momBuy: processed.momentumSummary.buy,
        momSell: processed.momentumSummary.sell,
        trendBuy: processed.trendSummary.buy,
        trendSell: processed.trendSummary.sell,
    };

    console.log("Processed Data:", processed); // Final processed data for debugging
    return processed;
}

// ==================================================================
// The helper functions are now integrated or assumed to be globally available.
// The local calculatePivotPointsSimple has been removed.
// ==================================================================


    // --- Final Signal Logic ---
    // (Using the version with refined scoring and reasoning)
    function calculateFinalSignal(processedData) {
        // Check dependencies first
        if (!processedData || !processedData.technicalSummary || !processedData.latest || !processedData.sentiment || !processedData.movingAveragesStatus) {
            console.error("Cannot calculate final signal: Missing required processed data fields for calculation.");
            return { signal: "Signal Error", reason: "Incomplete data for calculation.", score: 0 };
        }

        const summary = processedData.technicalSummary;
        let score = 0;
        let reasons = [];

        // --- Scoring Logic (Example - Adjust weights as needed) ---

        // Moving Averages Score (considering key MAs)
        let maScore = 0;
        let maReasons = [];
        // Weight 50 and 200 day more
        if(processedData.movingAveragesStatus.ma50?.includes('Buy')) { maScore += 1.0; maReasons.push("Price > 50MA"); }
        else if(processedData.movingAveragesStatus.ma50?.includes('Sell')) { maScore -= 1.0; maReasons.push("Price < 50MA"); }
        if(processedData.movingAveragesStatus.ma200?.includes('Buy')) { maScore += 1.0; maReasons.push("Price > 200MA"); }
        else if(processedData.movingAveragesStatus.ma200?.includes('Sell')) { maScore -= 1.0; maReasons.push("Price < 200MA"); }
        // Add short term MA influence with less weight
        if(processedData.movingAveragesStatus.ma20?.includes('Buy')) { maScore += 0.5; }
        else if(processedData.movingAveragesStatus.ma20?.includes('Sell')) { maScore -= 0.5; }
         // Add 100 day MA influence
        if(processedData.movingAveragesStatus.ma100?.includes('Buy')) { maScore += 0.5; }
        else if(processedData.movingAveragesStatus.ma100?.includes('Sell')) { maScore -= 0.5; }


        if(maScore !== 0) reasons.push(`MA Score: ${maScore > 0 ? '+' : ''}${maScore.toFixed(1)} (${maReasons.join('/')})`);
        else reasons.push("MA Neutral");
        score += maScore;


        // Momentum Score
        let momScore = summary.momBuy - summary.momSell;
        if(momScore !== 0) {
            score += momScore; // Add score based on difference
            reasons.push(`Momentum: ${momScore > 0 ? '+' : ''}${momScore} (Buy ${summary.momBuy}/Sell ${summary.momSell})`);
        } else if (summary.momBuy > 0 || summary.momSell > 0) { // Only add if oscillators were calculated
             reasons.push("Momentum Neutral");
        }


        // Trend Score (Weighted more heavily)
        let trendScore = (summary.trendBuy - summary.trendSell) * 1.5; // Weight can be adjusted
        if(trendScore !== 0) {
             score += trendScore;
             reasons.push(`Trend: ${trendScore > 0 ? '+' : ''}${trendScore.toFixed(1)} (Buy ${summary.trendBuy}/Sell ${summary.trendSell})`);
         } else if (summary.trendBuy > 0 || summary.trendSell > 0) { // Only add if oscillators were calculated
             reasons.push("Trend Neutral");
         }


        // Sentiment Score (Using 1M and 1W for different timeframe views)
        const sentiment1M = processedData.sentiment['1M'];
        const sentiment1W = processedData.sentiment['1W'];
        let sentimentScore = 0;
        // Monthly sentiment gets more weight
        if(sentiment1M?.includes('Strong Buy') || sentiment1M?.includes('Positive')) sentimentScore += 1.5; // Added ?. for safety & check for Positive
        else if(sentiment1M?.includes('Buy')) sentimentScore += 0.75; // Added ?. for safety
        else if(sentiment1M?.includes('Strong Sell') || sentiment1M?.includes('Negative')) sentimentScore -= 1.5; // Added ?. for safety & check for Negative
        else if(sentiment1M?.includes('Sell')) sentimentScore -= 0.75; // Added ?. for safety
         // Weekly sentiment gets less weight
        if(sentiment1W?.includes('Strong Buy') || sentiment1W?.includes('Positive')) sentimentScore += 0.5; // Added ?. for safety & check for Positive
        else if(sentiment1W?.includes('Buy')) sentimentScore += 0.25; // Added ?. for safety
        else if(sentiment1W?.includes('Strong Sell') || sentiment1W?.includes('Negative')) sentimentScore -= 0.5; // Added ?. for safety & check for Negative
        else if(sentiment1W?.includes('Sell')) sentimentScore -= 0.25; // Added ?. for safety


        if(sentimentScore !== 0) {
            score += sentimentScore;
            reasons.push(`Sentiment Score: ${sentimentScore > 0 ? '+' : ''}${sentimentScore.toFixed(2)}`);
        } else if (Object.values(processedData.sentiment).some(s => s !== 'N/A' && !String(s).includes('Neutral'))) {
             // Only add if sentiment wasn't completely N/A or Neutral
             reasons.push("Sentiment Neutral");
         }


        // --- Determine Final Signal based on Score ---
        let finalSignal = "Neutral";
        // --- ADJUST SCORE THRESHOLDS AS NEEDED ---
        // These thresholds determine the sensitivity of the signal
        const strongBuyThreshold = 6.0;
        const buyThreshold = 2.5;
        const strongSellThreshold = -6.0;
        const sellThreshold = -2.5;

        if (score >= strongBuyThreshold) finalSignal = "Strong Buy";
        else if (score >= buyThreshold) finalSignal = "Buy";
        else if (score <= strongSellThreshold) finalSignal = "Strong Sell";
        else if (score <= sellThreshold) finalSignal = "Sell";

        // Round final score for display consistency
        const finalScoreRounded = score.toFixed(1);

        // Construct reason string, handling empty reasons case
        const reasonString = reasons.length > 0 ? reasons.join('; ') : "No specific factors identified";

        return {
            signal: finalSignal,
            reason: reasonString + `. Final Score: ${finalScoreRounded}`,
            score: finalScoreRounded // Return rounded score
        };
    }


    // --- Chat Interface Functions ---
    function addChatMessage(htmlContent, type = 'bot', isHtml = true) {
        const messageElement = $('<div></div>')
            .addClass('message')
            .addClass(type); // type can be 'bot', 'error', 'loading', signal classes etc.

        if (isHtml) {
            // Basic sanitization (remove script tags). Use a library for robust needs.
            const sanitizedHtml = htmlContent.replace(/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/gi, '');
            messageElement.html(`<span>${sanitizedHtml}</span>`);
        } else {
            // For plain text, escape HTML and convert newlines
            const escapedText = $('<div>').text(htmlContent).html();
            messageElement.html(escapedText.replace(/\n/g, '<br>'));
        }

        chatbox.append(messageElement);
        // Scroll to the bottom smoothly
        chatbox.animate({ scrollTop: chatbox[0].scrollHeight }, 300); // Smooth scroll
    }

    function clearChat() {
        chatbox.empty();
    }

    // --- Automated Report Generation Sequence ---
    function runReportSequence(symbol, processedData){
        let delay = 100; // Initial delay
        const delayIncrement = 600; // Delay between messages (ms)

        // Message 1: Introduction
        setTimeout(() => {
            addChatMessage(`<strong><i class="fas fa-cogs"></i> Initiating Analysis for ${symbol}...</strong><br><small>Data based on last available trading day: ${processedData.latest.date || 'N/A'}</small>`);
        }, delay);
        delay += delayIncrement;

        // Message 2: Latest Price Action
        setTimeout(() => {
            const details = processedData.latest;
            const change = processedData.dailyChange;
            const percent = processedData.dailyChangePercent;
            const sign = change >= 0 ? "+" : "";
            const changeColor = change >= 0 ? '#16a34a' : '#dc2626'; // Use theme colors
            let dailyMoveDescription = "a relatively flat";
             // Check if percent is a valid number before using Math.abs
            if (typeof percent === 'number' && !isNaN(percent)) {
                 if (Math.abs(percent) > 2) dailyMoveDescription = "a significant";
                 else if (Math.abs(percent) > 0.5) dailyMoveDescription = "a moderate";
             } else {
                 dailyMoveDescription = "an undefined"; // Handle NaN percent
             }


            let closePositionDesc = "";
            if(typeof details.high === 'number' && typeof details.low === 'number' && typeof details.close === 'number' && !isNaN(details.high) && !isNaN(details.low) && !isNaN(details.close)){
                const range = details.high - details.low;
                if (range > 0) {
                     const closePosition = (details.close - details.low) / range;
                     if (closePosition > 0.75) closePositionDesc = " It closed near the high of its daily range, suggesting strong buying interest.";
                     else if (closePosition < 0.25) closePositionDesc = " It closed near the low of its daily range, indicating potential selling pressure.";
                     else closePositionDesc = " It closed near the middle of its daily range.";
                } else {
                    closePositionDesc = " The daily high and low were the same, indicating very low volatility or a data issue.";
                }
            } else {
                closePositionDesc = " Close position within daily range could not be determined due to invalid HLOC data.";
            }

            let content = `<strong><i class="fas fa-dollar-sign"></i> Latest Price Action Analysis</strong>`;
            content += `<div class="detail"><span class="detail-label">Last Close:</span> <span class="detail-value">${details.close?.toFixed(2) ?? 'N/A'}</span></div>`;
             // Check if dailyChange is NaN before displaying
            if (!isNaN(change) && !isNaN(percent)) {
                 content += `<div class="detail"><span class="detail-label">Daily Change:</span> <span class="detail-value" style="color:${changeColor}; font-weight:500;">${sign}${change?.toFixed(2) ?? 'N/A'} (${sign}${percent?.toFixed(2) ?? 'N/A'}%)</span></div>`;
            } else {
                 content += `<div class="detail"><span class="detail-label">Daily Change:</span> <span class="detail-value">N/A</span></div>`;
            }

            content += `<div class="detail"><span class="detail-label">Day's Range:</span> <span class="detail-value">${details.low?.toFixed(2) ?? 'N/A'} - ${details.high?.toFixed(2) ?? 'N/A'}</span></div>`;
            content += `<div class="detail"><span class="detail-label">Open:</span> <span class="detail-value">${details.open?.toFixed(2) ?? 'N/A'}</span></div>`;
            content += `<div class="detail"><span class="detail-label">Volume:</span> <span class="detail-value">${details.volume?.toLocaleString() ?? 'N/A'}</span></div>`;
            content += `<p>${dailyMoveDescription ? `The stock experienced ${dailyMoveDescription} move on the last trading day.` : ''}${closePositionDesc}</p>`;
            addChatMessage(content);
        }, delay);
        delay += delayIncrement;

        // Message 3: Moving Averages
        setTimeout(() => {
            const maData = processedData.movingAverages;
            const maStatus = processedData.movingAveragesStatus;
            const closePrice = processedData.latest.close;

            let trendDescription = "The short-term trend (vs 20-day MA) appears ";
            if (maStatus.ma20?.includes('Buy')) trendDescription += "positive. ";
            else if (maStatus.ma20?.includes('Sell')) trendDescription += "negative. ";
            else trendDescription += "neutral. ";

            trendDescription += "Medium-to-long term: ";
            const above50 = maStatus.ma50?.includes('Buy');
            const above200 = maStatus.ma200?.includes('Buy');
            const below50 = maStatus.ma50?.includes('Sell');
            const below200 = maStatus.ma200?.includes('Sell');

            if (above50 && above200) trendDescription += "a bullish trend is suggested (Price > 50 & 200 MAs).";
            else if (below50 && below200) trendDescription += "a bearish trend is suggested (Price < 50 & 200 MAs).";
            else if (above50 && below200) trendDescription += "mixed signals (Price > 50MA, < 200MA) - watch 200MA resistance.";
            else if (below50 && above200) trendDescription += "mixed signals (Price < 50MA, > 200MA) - watch 200MA support.";
            else trendDescription += "the trend is unclear based on 50/200 MAs.";

            let content = `<strong><i class="fas fa-chart-line"></i> Moving Average Analysis</strong>`;
            content += `<p>Moving averages smooth price data to indicate trend direction and potential support/resistance zones.</p>`;
            content += `<div class="detail"><span class="detail-label">Current Price:</span> <span class="detail-value">${closePrice?.toFixed(2) ?? 'N/A'}</span></div>`;
            content += `<div class="detail"><span class="detail-label">20-Day MA:</span> <span class="detail-value">${maData.ma20?.toFixed(2) ?? 'N/A'} (${maStatus.ma20 ?? 'N/A'})</span></div>`;
            content += `<div class="detail"><span class="detail-label">50-Day MA:</span> <span class="detail-value">${maData.ma50?.toFixed(2) ?? 'N/A'} (${maStatus.ma50 ?? 'N/A'})</span></div>`;
            content += `<div class="detail"><span class="detail-label">100-Day MA:</span> <span class="detail-value">${maData.ma100?.toFixed(2) ?? 'N/A'} (${maStatus.ma100 ?? 'N/A'})</span></div>`;
            content += `<div class="detail"><span class="detail-label">200-Day MA:</span> <span class="detail-value">${maData.ma200?.toFixed(2) ?? 'N/A'} (${maStatus.ma200 ?? 'N/A'})</span></div>`;
            content += `<p>${trendDescription}</p>`;
            addChatMessage(content);
        }, delay);
        delay += delayIncrement;

        // Message 4: Returns Analysis
        setTimeout(() => {
            const returns = processedData.returns;
            let content = `<strong><i class="fas fa-percentage"></i> Performance Snapshot (Returns)</strong>`;
             content += `<p>Shows the stock's percentage change over various recent periods.</p>`;
            content += `<div class="detail"><span class="detail-label">Daily:</span> <span class="detail-value">${returns.daily ?? 'N/A'}</span></div>`;
            content += `<div class="detail"><span class="detail-label">Weekly (5d):</span> <span class="detail-value">${returns.weekly ?? 'N/A'}</span></div>`;
            content += `<div class="detail"><span class="detail-label">Monthly (21d):</span> <span class="detail-value">${returns.monthly ?? 'N/A'}</span></div>`;
            content += `<div class="detail"><span class="detail-label">Yearly (252d):</span> <span class="detail-value">${returns.yearly ?? 'N/A'}</span></div>`;
            addChatMessage(content);
        }, delay);
        delay += delayIncrement;

        // Message 5: Market Sentiment
        setTimeout(() => {
            const sentiment = processedData.sentiment;
            let sentimentSummary = "Overall sentiment appears ";
             // Count positive/negative based on keywords
            const buySignals = Object.values(sentiment).filter(s => s && (s.includes('Strong Buy') || s.includes('Buy') || s.includes('Positive'))).length;
            const sellSignals = Object.values(sentiment).filter(s => s && (s.includes('Strong Sell') || s.includes('Sell') || s.includes('Negative'))).length;


            if (buySignals > sellSignals && buySignals >= 2) sentimentSummary += "positive, especially short-term.";
            else if (sellSignals > buySignals && sellSignals >= 2) sentimentSummary += "negative, particularly longer-term.";
            else sentimentSummary += "mixed or neutral across timeframes.";

            let content = `<strong><i class="fas fa-heartbeat"></i> Market Sentiment Indicators</strong>`;
            content += `<p>Gauges market mood based on recent price changes (positive change = positive sentiment).</p>`;
            content += `<div class="detail"><span class="detail-label">1 Day:</span> <span class="detail-value">${sentiment['1D'] ?? 'N/A'}</span></div>`;
            content += `<div class="detail"><span class="detail-label">1 Week:</span> <span class="detail-value">${sentiment['1W'] ?? 'N/A'}</span></div>`;
            content += `<div class="detail"><span class="detail-label">1 Month:</span> <span class="detail-value">${sentiment['1M'] ?? 'N/A'}</span></div>`;
            content += `<div class="detail"><span class="detail-label">3 Months:</span> <span class="detail-value">${sentiment['3M'] ?? 'N/A'}</span></div>`;
            content += `<p>${sentimentSummary}</p>`;
            addChatMessage(content);
        }, delay);
        delay += delayIncrement;

        // Message 6: Pivot Points (Includes Classic, Fibonacci, Woodie, Camarilla, Demark)
        setTimeout(() => {
            // Check if any pivot data is available, specifically Classic PP as a primary check
            if (!processedData.pivotPoints || !processedData.pivotPoints.classic || isNaN(parseFloat(processedData.pivotPoints.classic.P))) {
                 addChatMessage("<strong><i class='fas fa-map-pin'></i> Pivot Points Analysis</strong><p>Could not calculate Pivot Points (missing or invalid data). Ensure latest day's HLOC data is available and numeric.</p>", 'error');
                 return; // Skip if pivot data is bad
             }

            const pivots = processedData.pivotPoints;
            const closePrice = processedData.latest.close;

            let content = `<strong><i class="fas fa-map-pin"></i> Pivot Points Analysis</strong>`;
            content += `<p>Potential support/resistance levels for the <i>next</i> trading session based on the previous day's price action. Use these levels as potential areas for price reversals or consolidation.</p>`;

            // --- Classic Pivot Points Table ---
            if (pivots.classic && !isNaN(parseFloat(pivots.classic.P))) {
                 content += `<h4>Classic Pivot Points</h4>`;
                 let classicTableHtml = `<table class="bot-table">
                     <tr><th>Level</th><th>Value</th><th>Level</th><th>Value</th></tr>
                     <tr><td>Resistance 3 (R3)</td><td>${pivots.classic.R3 ?? 'N/A'}</td><td>Support 1 (S1)</td><td>${pivots.classic.S1 ?? 'N/A'}</td></tr>
                     <tr><td>Resistance 2 (R2)</td><td>${pivots.classic.R2 ?? 'N/A'}</td><td>Support 2 (S2)</td><td>${pivots.classic.S2 ?? 'N/A'}</td></tr>
                     <tr><td>Resistance 1 (R1)</td><td>${pivots.classic.R1 ?? 'N/A'}</td><td>Support 3 (S3)</td><td>${pivots.classic.S3 ?? 'N/A'}</td></tr>
                     <tr><td colspan="2" style="text-align:center; font-weight:bold;">Pivot Point (PP)</td><td colspan="2" style="text-align:center; font-weight:bold;">${pivots.classic.P ?? 'N/A'}</td></tr>
                 </table>`;
                 content += classicTableHtml;
                 // Add comparison to Classic PP
                 const ppValue = parseFloat(pivots.classic.P);
                 if (!isNaN(ppValue) && !isNaN(closePrice)) {
                     let classicContext = `Based on Classic PP (${pivots.classic.P}), the current price (${closePrice?.toFixed(2)}) is `;
                     if (closePrice > ppValue) classicContext += "above it, suggesting potential bullish sentiment.";
                     else if (closePrice < ppValue) classicContext += "below it, suggesting potential bearish sentiment.";
                     else classicContext += "right at the pivot point, indicating potential indecision.";
                     content += `<p>${classicContext}</p>`;
                 }
             } else {
                  content += `<p><i>Classic Pivot Points could not be calculated.</i></p>`;
             }


             // --- Fibonacci Pivot Points Table ---
             if (pivots.fibonacci && !isNaN(parseFloat(pivots.fibonacci.P))) { // Check if Fibonacci data is valid
                content += `<h4>Fibonacci Pivot Points</h4>`;
                let fibonacciTableHtml = `<table class="bot-table">
                     <tr><th>Level</th><th>Value</th><th>Level</th><th>Value</th></tr>
                     <tr><td>Resistance 3 (R3)</td><td>${pivots.fibonacci.R3 ?? 'N/A'}</td><td>Support 1 (S1)</td><td>${pivots.fibonacci.S1 ?? 'N/A'}</td></tr>
                     <tr><td>Resistance 2 (R2)</td><td>${pivots.fibonacci.R2 ?? 'N/A'}</td><td>Support 2 (S2)</td><td>${pivots.fibonacci.S2 ?? 'N/A'}</td></tr>
                     <tr><td>Resistance 1 (R1)</td><td>${pivots.fibonacci.R1 ?? 'N/A'}</td><td>Support 3 (S3)</td><td>${pivots.fibonacci.S3 ?? 'N/A'}</td></tr>
                     <tr><td colspan="2" style="text-align:center; font-weight:bold;">Pivot Point (PP)</td><td colspan="2" style="text-align:center; font-weight:bold;">${pivots.fibonacci.P ?? 'N/A'}</td></tr>
                 </table>`;
                 content += fibonacciTableHtml;
             } else {
                 content += `<p><i>Fibonacci Pivot Points could not be calculated.</i></p>`;
             }


             // --- Woodie Pivot Points Table ---
              if (pivots.woodie && !isNaN(parseFloat(pivots.woodie.P))) { // Check if Woodie data is valid
                content += `<h4>Woodie Pivot Points</h4>`;
                let woodieTableHtml = `<table class="bot-table">
                     <tr><th>Level</th><th>Value</th><th>Level</th><th>Value</th></tr>
                     <tr><td>Resistance 2 (R2)</td><td>${pivots.woodie.R2 ?? 'N/A'}</td><td>Support 1 (S1)</td><td>${pivots.woodie.S1 ?? 'N/A'}</td></tr>
                     <tr><td>Resistance 1 (R1)</td><td>${pivots.woodie.R1 ?? 'N/A'}</td><td>Support 2 (S2)</td><td>${pivots.woodie.S2 ?? 'N/A'}</td></tr>
                     <tr><td colspan="2" style="text-align:center; font-weight:bold;">Pivot Point (PP)</td><td colspan="2" style="text-align:center; font-weight:bold;">${pivots.woodie.P ?? 'N/A'}</td></tr>
                 </table>`;
                 content += woodieTableHtml;
             } else {
                  content += `<p><i>Woodie Pivot Points could not be calculated (requires valid Open price).</i></p>`;
             }

             // --- Camarilla Pivot Points Table ---
             if (pivots.camarilla && !isNaN(parseFloat(pivots.camarilla.P))) { // Check if Camarilla data is valid
                 content += `<h4>Camarilla Pivot Points</h4>`;
                 let camarillaTableHtml = `<table class="bot-table">
                      <tr><th>Level</th><th>Value</th><th>Level</th><th>Value</th></tr>
                      <tr><td>Resistance 4 (R4)</td><td>${pivots.camarilla.R4 ?? 'N/A'}</td><td>Support 1 (S1)</td><td>${pivots.camarilla.S1 ?? 'N/A'}</td></tr>
                      <tr><td>Resistance 3 (R3)</td><td>${pivots.camarilla.R3 ?? 'N/A'}</td><td>Support 2 (S2)</td><td>${pivots.camarilla.S2 ?? 'N/A'}</td></tr>
                      <tr><td>Resistance 2 (R2)</td><td>${pivots.camarilla.R2 ?? 'N/A'}</td><td>Support 3 (S3)</td><td>${pivots.camarilla.S3 ?? 'N/A'}</td></tr>
                      <tr><td>Resistance 1 (R1)</td><td>${pivots.camarilla.R1 ?? 'N/A'}</td><td>Support 4 (S4)</td><td>${pivots.camarilla.S4 ?? 'N/A'}</td></tr>
                       <tr><td colspan="2" style="text-align:center; font-weight:bold;">Pivot Point (PP)</td><td colspan="2" style="text-align:center; font-weight:bold;">${pivots.camarilla.P ?? 'N/A'}</td></tr>
                  </table>`;
                  content += camarillaTableHtml;
              } else {
                   content += `<p><i>Camarilla Pivot Points could not be calculated.</i></p>`;
              }

               // --- Demark Pivot Points Table ---
              if (pivots.demark && !isNaN(parseFloat(pivots.demark.P))) { // Check if Demark data is valid
                 content += `<h4>Demark Pivot Points</h4>`;
                 let demarkTableHtml = `<table class="bot-table">
                      <tr><th>Level</th><th>Value</th></tr>
                      <tr><td>Resistance 1 (R1)</td><td>${pivots.demark.R1 ?? 'N/A'}</td></tr>
                      <tr><td>Support 1 (S1)</td><td>${pivots.demark.S1 ?? 'N/A'}</td></tr>
                      <tr><td style="text-align:center; font-weight:bold;">Pivot Point (PP)</td><td>${pivots.demark.P ?? 'N/A'}</td></tr>
                  </table>`;
                  content += demarkTableHtml;
              } else {
                   content += `<p><i>Demark Pivot Points could not be calculated (requires valid Open and Close).</i></p>`;
              }


            // Removed the generic pivotContext paragraph and integrated context into Classic section above
            addChatMessage(content);
        }, delay);
        delay += delayIncrement;

        // Message 7: Oscillator Summaries
        setTimeout(() => {
            const mom = processedData.momentumSummary;
            const trend = processedData.trendSummary;
            let oscDesc = "Momentum oscillators (like RSI, Stochastics) measure the speed/rate of price change. Trend oscillators (like MACD, ADX) help identify trend direction and strength.";

            let content = `<strong><i class="fas fa-tachometer-alt"></i> Technical Oscillator Summary</strong>`;
            content += `<p>${oscDesc}</p>`;

             // Display Momentum summary if calculated, otherwise show placeholder
            if (typeof calculateMomentumOscillators === 'function') {
                 content += `<div class="detail"><span class="detail-label">Momentum Summary:</span> <span class="detail-value"><span style="color: #22c55e;">Buy: ${mom.buy}</span>, <span style="color: #f43f5e;">Sell: ${mom.sell}</span>, <span style="color: #6b7280;">Neutral: ${mom.neutral}</span></span></div>`;
            } else {
                 content += `<p><i>Momentum Oscillator calculations are not available. Ensure oscillatorAnalysis.js is loaded correctly.</i></p>`;
            }

            // Display Trend summary if calculated, otherwise show placeholder
            if (typeof calculateTrendOscillators === 'function') {
                 content += `<div class="detail"><span class="detail-label">Trend Summary:</span> <span class="detail-value"><span style="color: #22c55e;">Buy: ${trend.buy}</span>, <span style="color: #f43f5e;">Sell: ${trend.sell}</span>, <span style="color: #6b7280;">Neutral: ${trend.neutral}</span></span></div>`;
            } else {
                 content += `<p><i>Trend Oscillator calculations are not available. Ensure the function calculateTrendOscillators is loaded.</i></p>`;
            }

            addChatMessage(content);
        }, delay);
        delay += delayIncrement;

        // Message 8: Final Signal Calculation
        setTimeout(() => {
            const { signal, reason, score } = calculateFinalSignal(processedData);
            let signalClass = 'signal-neutral'; // Default class
            if (signal === "Strong Buy") signalClass = 'signal-strong-buy';
            else if (signal === "Buy") signalClass = 'signal-buy';
            else if (signal === "Strong Sell") signalClass = 'signal-strong-sell';
            else if (signal === "Sell") signalClass = 'signal-sell';
            else if (signal === "Signal Error") signalClass = 'signal-error';

            let interpretation = "";
            switch(signal) {
                case "Strong Buy": interpretation = "Multiple technical factors strongly favor potential upward price movement. Consider bullish strategies."; break;
                case "Buy": interpretation = "Technical factors lean towards a positive outlook, suggesting potential gains. Monitor for confirmation."; break;
                case "Neutral": interpretation = "Technical factors are mixed or unclear, suggesting potential consolidation or lack of a strong directional bias. Exercise caution or wait for clearer signals."; break;
                case "Sell": interpretation = "Technical factors lean towards a negative outlook, suggesting potential price declines. Consider bearish strategies or reducing exposure."; break;
                case "Strong Sell": interpretation = "Multiple technical factors strongly favor potential downward price movement. Consider bearish strategies or exiting positions."; break;
                case "Signal Error": interpretation = "Could not reliably determine a final signal due to data processing issues."; break;
            }

            let content = `<strong><i class="fas fa-compass"></i> Consolidated Technical Signal</strong>`;
            content += `<p>This signal combines insights from Moving Averages, Oscillators, and Sentiment analysis based on a predefined scoring model. It provides a synthesized view, but should be used in conjunction with other analysis.</p>`;
            content += `<div style="font-size: 1.3em; font-weight: 600; margin: 12px 0; text-align: center; padding: 8px 5px; border-radius: 5px; color: var(--chat-text-color); min-width: 150px; display: inline-block;" class="${signalClass}">${signal}</div>`; // Apply class directly for background
            content += `<p style="font-size: 1.0em; text-align: center; margin-bottom: 12px; font-style: italic; color: var(--chat-text-color);">${interpretation}</p>`; // Added color
            content += `<div style="font-size: 0.9em; color: var(--chat-detail-color);"><strong>Basis for Signal:</strong> ${reason}</div>`; // Added color
            addChatMessage(content, signalClass); // Pass class for message container styling too
        }, delay);
        delay += delayIncrement;

         // Message 9: Disclaimer
        setTimeout(() => {
             let disclaimerContent = `<div style="border-top: 1px dashed var(--chat-border-color); padding-top: 10px; margin-top: 10px; font-size: 0.85em; color: var(--chat-detail-color);">`; // Added theme colors and adjusted font size
             disclaimerContent += `<i><strong><i class="fas fa-exclamation-triangle"></i> Disclaimer:</strong> This is an automated technical analysis based on historical data (Last Refreshed: ${processedData?.latest?.date ?? 'N/A'}). It is for informational purposes only and DOES NOT constitute financial or investment advice. Market conditions are dynamic and past performance is not indicative of future results. </i><br><br>`;
             disclaimerContent += `<i>Always conduct your own thorough research, consider fundamental factors, and consult with a qualified financial advisor before making any investment decisions. Understand your risk tolerance and manage your capital effectively.</i>`;
             disclaimerContent += `</div>`;
             addChatMessage(disclaimerContent);
         }, delay);
    }

    const TWELVE_DATA_API_KEY = "e2fb0acfee10401da4f7151094e4e6b2"; // <--- PUT YOUR API KEY HERE - ENSURE THIS IS CORRECT

    // --- Main Logic: Load Data and Trigger Report ---
    function loadStockDataAndGenerateReport(symbol) {
        clearChat();
        addChatMessage(`<i class="fas fa-spinner fa-spin"></i> Loading and analyzing data for ${symbol}... Please wait.`, 'loading');

        // Construct the API URL
        const dataPath = `https://api.twelvedata.com/time_series?symbol=${symbol}&interval=1day&outputsize=5000&apikey=${TWELVE_DATA_API_KEY}`;
        console.log(`Attempting to load data from Twelve Data API: ${dataPath}`);

        $.getJSON(dataPath)
            .done(function (response) {
                console.log(`Data successfully loaded for ${symbol}:`, response);
                const processedData = processStockDataForReport(response);

                clearChat(); // Clear loading message

                if (processedData) {
                    // Start the report generation sequence
                    runReportSequence(symbol, processedData);
                } else {
                    addChatMessage(`Failed to process the loaded data for ${symbol}. This might be due to insufficient or invalid historical data from the API (especially for the latest HLOC). Check the browser console for details.`, "error");
                }
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                console.error(`Error loading stock data from ${dataPath}:`, textStatus, errorThrown, jqXHR.responseText);
                clearChat(); // Clear loading message
                let errorMsg = `Sorry, I couldn't load the data for ${symbol}. `;
                if (jqXHR.status === 401) {
                    errorMsg += `API Key is invalid or missing. Please check your Twelve Data API key.`;
                } else if (jqXHR.status === 404) {
                    errorMsg += `Data not found for ${symbol}. The symbol might be incorrect or not available on the selected exchange.`;
                } else if (jqXHR.responseJSON && jqXHR.responseJSON.message) {
                     errorMsg += `API Error: ${jqXHR.responseJSON.message}`;
                 } else if (errorThrown) {
                     errorMsg += `Error: ${errorThrown}.`;
                 } else {
                     errorMsg += `An unknown error occurred during data fetching.`;
                 }
                 errorMsg += ` Please check the symbol, your API key, and your network connection. Check the browser console for more details.`;
                addChatMessage(errorMsg, "error");
            });
    }

    // --- Event Listeners ---
    stockSelector.on('change', function () {
        const selectedSymbol = $(this).val();
        if (selectedSymbol) {
            loadStockDataAndGenerateReport(selectedSymbol);
        } else {
             clearChat();
             addChatMessage("Select a stock from the dropdown above to get the analysis report.", "placeholder");
        }
    });

    // --- Initial Load ---
    // The loadSymbolsFromApi function (defined in the <script> tag in the HTML)
    // should populate the dropdown. The 'change' event triggered by the user's selection
    // or the default selected value will initiate the report.
    // Ensure your HTML has a placeholder message initially in the chatbox.

    // A brief timeout to allow the stock selector to potentially load symbols if not already done
     // This is a fallback; the 'change' event is the primary trigger.
     setTimeout(() => {
         if (stockSelector.val()) {
              // If a symbol is already selected (e.g., page refresh retaining selection), load it.
              // loadStockDataAndGenerateReport(stockSelector.val()); // This would cause a double load if change event also fires
              // Rely purely on the change event from select2 initialization or user click
         } else {
            // Ensure initial placeholder is visible if no symbol is selected and no data is loading
             if ($('#chatbox .message.placeholder').length === 0 && $('#chatbox .message.loading').length === 0) {
                 addChatMessage("Select a stock from the dropdown above to get the analysis report.", "placeholder");
             }
         }
     }, 200); // Small delay


}); // End of document ready

// NOTE: Ensure pivotCalculations.js and oscillatorAnalysis.js are included as <script> tags in your HTML file
// BEFORE chatbot.js to make the getPivotCalculations and calculateMomentumOscillators functions available globally.
// You may also need to include a calculateTrendOscillators function from another file if you use it.