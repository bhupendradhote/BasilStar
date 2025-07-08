// main.js

const FMP_API_KEY = "T8HogSezq0WNy97WinOjjLMEOuiKjnu5";

function loadStock(symbol) {
    const apiUrl = `https://financialmodelingprep.com/api/v3/historical-price-full/${symbol}?apikey=${FMP_API_KEY}`;

    $.ajax({
        url: apiUrl,
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            if (!response || !response.historical || response.historical.length === 0) {
                console.error("No historical data received for symbol:", symbol);
                showMessageBox(`No historical data found for ${symbol}.`);
                return;
            }

            const timeSeriesData = response.historical.slice().reverse(); // Chronological
            const dates = timeSeriesData.map(item => item.date);
            const closingPrices = timeSeriesData.map(item => parseFloat(item.close));
            const highPrices = timeSeriesData.map(item => parseFloat(item.high));
            const lowPrices = timeSeriesData.map(item => parseFloat(item.low));

            const formattedData = {};
            timeSeriesData.forEach(item => {
                formattedData[item.date] = {
                    "1. open": item.open,
                    "2. high": item.high,
                    "3. low": item.low,
                    "4. close": item.close,
                    "5. volume": item.volume
                };
            });

            const latest = timeSeriesData[timeSeriesData.length - 1];
            if (!latest) {
                showMessageBox(`Invalid data format for ${symbol}.`);
                return;
            }

            const { high, low, close, open, change, changePercent, volume } = latest;

            // 🎯 Populate data grid
            $('#latestOpen').text(open.toFixed(2));
            $('#latestHigh').text(high.toFixed(2));
            $('#latestLow').text(low.toFixed(2));
            $('#latestClose').text(close.toFixed(2));
            $('#latestVolume').text(volume.toLocaleString());

            // Color logic
            const changeText = (change >= 0 ? "+" : "") + change.toFixed(2);
            const changePercentText = (changePercent >= 0 ? "+" : "") + changePercent.toFixed(2) + "%";
            const changeClass = change > 0 ? 'text-success' : (change < 0 ? 'text-danger' : 'text-muted');

            $('#priceChange')
                .text(changeText)
                .removeClass('text-success text-danger text-muted')
                .addClass(changeClass);

            $('#percentChange')
                .text(changePercentText)
                .removeClass('text-success text-danger text-muted')
                .addClass(changeClass);

            // 52-week calculations
            const last52 = timeSeriesData.slice(-260); // Approx 1 year
            const high52 = Math.max(...last52.map(d => d.high));
            const low52 = Math.min(...last52.map(d => d.low));
            const range52 = `${low52.toFixed(2)} - ${high52.toFixed(2)}`;

            $('#fiftyTwoWeekHigh').text(high52.toFixed(2));
            $('#fiftyTwoWeekLow').text(low52.toFixed(2));
            $('#fiftyTwoWeekRange').text(range52);
            $('#marketStatus').text("CLOSED");

            // Extended data (duplicate)
            $('#extendedPrice').text(close.toFixed(2));
            $('#extendedChange')
                .text(changeText)
                .removeClass('text-success text-danger text-muted')
                .addClass(changeClass);
            $('#extendedPercentChange')
                .text(changePercentText)
                .removeClass('text-success text-danger text-muted')
                .addClass(changeClass);

            // 📈 Existing chart and analysis
            renderStockChart(dates, closingPrices, symbol);
            showLatestDetails(formattedData, symbol);
            showPast10Days(formattedData);

            const descriptions = generateStockChangeDescriptions(dates, closingPrices);
            $('#descDaily').text(descriptions.daily);
            $('#descWeekly').text(descriptions.weekly);
            $('#descMonthly').text(descriptions.monthly);
            $('#descYearly').text(descriptions.yearly);

            const maPeriods = [20, 50, 100, 200];
            maPeriods.forEach(period => {
                const status = checkMovingAverage(dates, closingPrices, period);
                $(`#ma${period}Status`).html(status);
            });

            const sentiments = getSentimentByTimeframe(formattedData);
            $('#sentiment1d').html(sentiments["1D"]);
            $('#sentiment1w').html(sentiments["1W"]);
            $('#sentiment1m').html(sentiments["1M"]);
            $('#sentiment3m').html(sentiments["3M"]);

            const pivotLevels = getPivotCalculations(high, low, close, open);
            renderPivotMatrixTable(pivotLevels);

            const { buy, sell, neutral } = calculateMomentumOscillators(closingPrices, highPrices, lowPrices);
            $('#momentumSummary').text(`Momentum Oscillators (Buy: ${buy}) (Sell: ${sell}) (Neutral: ${neutral})`);

            analyzeMarketExtras(formattedData, dates);

            const trendResult = calculateTrendOscillators(closingPrices, highPrices, lowPrices);
            $('#trendSummary').text(`Trend Oscillators (Buy: ${trendResult.buy}) (Sell: ${trendResult.sell}) (Neutral: ${trendResult.neutral})`);
            
            
            // Other info
            fetchBalanceSheet(symbol);
            fetchStockStatistics(symbol);
            fetchFundamentalDividentsData(symbol);
            fetchFundamentalSplitssData(symbol);
            fetchIncomeStatement(symbol);
            fetchCompanyProfile(symbol);
            fetchCashFlow(symbol);
            // fetchQuoteData(symbol);
            fetchEarningsData(symbol);
            // fetchInstitutionalOwnership(symbol);
            
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error("AJAX Error:", textStatus, errorThrown);
            showMessageBox(`Failed to fetch historical data for ${symbol}.`);
        }
    });
}

function loadSymbolsFromApi(exchangeShort) {
    const url = `/data/nse_bse_symbols.json`; // Local JSON instead of FMP API

    $.ajax({
        url,
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            if (!data || data.length === 0) {
                console.error(`No symbols data received.`);
                showMessageBox(`Failed to load local symbol list.`);
                return;
            }

            const dropdown = $('#stockSelector');
            dropdown.empty();

            data.forEach(stock => {
                if ((exchangeShort === 'NSE' && stock.symbol.endsWith('.NS')) ||
                    (exchangeShort === 'BSE' && stock.symbol.endsWith('.BO'))) {
                    dropdown.append(`<option value="${stock.symbol}">${stock.name} (${stock.symbol})</option>`);
                }
            });

            dropdown.select2({
                placeholder: `Search for a stock in ${exchangeShort}...`,
                allowClear: true
            });

            const defaultSymbol = dropdown.val();
            if (defaultSymbol) {
                loadStock(defaultSymbol);
            } else {
                $('#analysis-output').addClass('hidden');
                showMessageBox('Please select a stock to begin analysis.', 'info');
            }

            dropdown.on('change', function () {
                const selected = $(this).val();
                if (selected) loadStock(selected);
            });
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error(`Failed to fetch local symbol list:`, textStatus, errorThrown);
            showMessageBox(`Error loading symbols. Please ensure nse_bse_symbols.json is in /static/data.`);
        }
    });
}


function showMessageBox(message) {
    alert(message);
}

$(document).ready(function () {
    loadSymbolsFromApi('NSE'); // Default to NSE

    $('#exchangeSwitch').on('change', function () {
        const selectedExchange = $(this).val(); // NSE or BSE
        loadSymbolsFromApi(selectedExchange);
    });

    $('#stockSelector').on('change', function () {
        loadStock(this.value);
    });
});
