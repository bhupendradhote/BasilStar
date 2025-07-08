function calculateMomentumOscillators(closingPrices, highPrices, lowPrices) {
    let buy = 0, sell = 0, neutral = 0;
    const results = [];

    // --- RSI ---
    const rsi = calculateRSI(closingPrices, 14);
    const rsiAction = getAction(rsi, 30, 70, false);
    countSignal(rsiAction);
    results.push({ name: "RSI (14)", value: rsi.toFixed(2), action: rsiAction });

    // --- Stochastic RSI (normalized RSI)
    const stochRsi = calculateStochasticRSI(closingPrices, 14);
    const stochRsiAction = getAction(stochRsi, 20, 80, false);
    countSignal(stochRsiAction);
    results.push({ name: "STOCHRSI (14)", value: stochRsi.toFixed(2), action: stochRsiAction });

    // --- Williams %R
    const williamsR = calculateWilliamsR(highPrices, lowPrices, closingPrices, 14);
    const williamsAction = getAction(williamsR, -80, -20, true);
    countSignal(williamsAction);
    results.push({ name: "Williams %R", value: williamsR.toFixed(2), action: williamsAction });

    // --- CCI
    const cci = calculateCCI(highPrices, lowPrices, closingPrices, 14);
    const cciAction = getAction(cci, -100, 100, false);
    countSignal(cciAction);
    results.push({ name: "CCI (14)", value: cci.toFixed(2), action: cciAction });

    // --- Rate of Change (ROC)
    const roc = calculateROC(closingPrices, 12);
    const rocAction = getAction(roc, 0, 0, false); // ROC: above 0 = buy, below = sell
    countSignal(rocAction);
    results.push({ name: "ROC", value: roc.toFixed(2), action: rocAction });
    
    
const summaryText = `Momentum Oscillators (Buy: ${buy}) (Sell: ${sell}) (Neutral: ${neutral})`;

const summaryElem = document.getElementById("momentumSummary");
if (summaryElem) summaryElem.textContent = summaryText;

let tableHTML = `<table><thead><tr><th>Name</th><th>Value</th><th>Action</th></tr></thead><tbody>`;
results.forEach(row => {
    tableHTML += `<tr><td>${row.name}</td><td>${row.value}</td><td>${row.action}</td></tr>`;
});
tableHTML += `</tbody></table>`;

const tableElem = document.getElementById("momentumTable");
if (tableElem) tableElem.innerHTML = tableHTML;

    

    return { buy, sell, neutral, results };

    // --- helper functions
    function countSignal(action) {
        if (action === 'buy') buy++;
        else if (action === 'sell') sell++;
        else neutral++;
    }

    function getAction(value, lower, upper, isNegativeScale) {
        if (isNegativeScale) {
            if (value > upper) return 'buy';
            else if (value < lower) return 'sell';
        } else {
            if (value > upper) return 'sell';
            else if (value < lower) return 'buy';
        }
        return 'neutral';
    }
}

// --- RSI ---
function calculateRSI(prices, period) {
    let gains = 0, losses = 0;
    for (let i = 1; i <= period; i++) {
        const diff = prices[prices.length - i] - prices[prices.length - i - 1];
        if (diff > 0) gains += diff;
        else losses -= diff;
    }
    const rs = gains / (losses || 1);
    return 100 - (100 / (1 + rs));
}

// --- Stochastic RSI ---
function calculateStochasticRSI(prices, period) {
    const rsiValues = [];
    for (let i = period; i < prices.length; i++) {
        rsiValues.push(calculateRSI(prices.slice(0, i + 1), period));
    }
    const latestRSI = rsiValues[rsiValues.length - 1];
    const minRSI = Math.min(...rsiValues.slice(-period));
    const maxRSI = Math.max(...rsiValues.slice(-period));
    return ((latestRSI - minRSI) / (maxRSI - minRSI)) * 100;
}

// --- Williams %R ---
function calculateWilliamsR(high, low, close, period) {
    const highestHigh = Math.max(...high.slice(-period));
    const lowestLow = Math.min(...low.slice(-period));
    const recentClose = close[close.length - 1];
    return ((highestHigh - recentClose) / (highestHigh - lowestLow)) * -100;
}

// --- CCI ---
function calculateCCI(high, low, close, period = 14) {
    const tp = [];
    for (let i = 0; i < close.length; i++) {
        tp.push((high[i] + low[i] + close[i]) / 3);
    }
    const tpSlice = tp.slice(-period);
    const meanTP = tpSlice.reduce((a, b) => a + b, 0) / period;
    const meanDeviation = tpSlice.reduce((acc, val) => acc + Math.abs(val - meanTP), 0) / period;
    return (tp[tp.length - 1] - meanTP) / (0.015 * meanDeviation);
}

// --- ROC ---
function calculateROC(prices, period) {
    return ((prices[prices.length - 1] - prices[prices.length - 1 - period]) / prices[prices.length - 1 - period]) * 100;
}