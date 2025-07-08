function calculateTrendOscillators(closingPrices, highPrices, lowPrices) {
    let buy = 0, sell = 0, neutral = 0;

    // --- MACD Calculation ---
    const macd = calculateMACD(closingPrices);
    const macdAction = macd.histogram > 0 ? "buy" : macd.histogram < 0 ? "sell" : "neutral";
    if (macdAction === "buy") buy++;
    else if (macdAction === "sell") sell++;
    else neutral++;

    // --- ADX Calculation ---
    const adx = calculateADX(closingPrices, highPrices, lowPrices, 14);
    const adxAction = adx > 25 ? "buy" : adx < 20 ? "sell" : "neutral";
    if (adxAction === "buy") buy++;
    else if (adxAction === "sell") sell++;
    else neutral++;

    // Update the DOM
    $('#trendSummary').text(`Trend Oscillators (Buy: ${buy}) (Sell: ${sell}) (Neutral: ${neutral})`);

    $('#trendMACD .trend-value').text(macd.histogram.toFixed(2));
    $('#trendMACD .trend-action').text(macdAction);

    $('#trendADX .trend-value').text(adx.toFixed(2));
    $('#trendADX .trend-action').text(adxAction);

    return { buy, sell, neutral };
}


function calculateADX(close, high, low, period = 14) {
    const plusDM = [];
    const minusDM = [];
    const trList = [];

    for (let i = 1; i < close.length; i++) {
        const highDiff = high[i] - high[i - 1];
        const lowDiff = low[i - 1] - low[i];

        plusDM.push(highDiff > lowDiff && highDiff > 0 ? highDiff : 0);
        minusDM.push(lowDiff > highDiff && lowDiff > 0 ? lowDiff : 0);

        const tr = Math.max(
            high[i] - low[i],
            Math.abs(high[i] - close[i - 1]),
            Math.abs(low[i] - close[i - 1])
        );
        trList.push(tr);
    }

    const smoothedTR = average(trList.slice(-period));
    const smoothedPlusDM = average(plusDM.slice(-period));
    const smoothedMinusDM = average(minusDM.slice(-period));

    const plusDI = 100 * (smoothedPlusDM / smoothedTR);
    const minusDI = 100 * (smoothedMinusDM / smoothedTR);
    const dx = 100 * Math.abs((plusDI - minusDI) / (plusDI + minusDI));

    return dx;
}

function average(arr) {
    return arr.reduce((a, b) => a + b, 0) / arr.length;
}


function calculateMACD(closingPrices, shortPeriod = 12, longPeriod = 26, signalPeriod = 9) {
    if (closingPrices.length < longPeriod + signalPeriod) {
        return { macdLine: [], signalLine: [], histogram: 0 };
    }

    const emaShort = calculateEMA(closingPrices, shortPeriod);
    const emaLong = calculateEMA(closingPrices, longPeriod);

    const macdLine = [];
    for (let i = 0; i < emaLong.length; i++) {
        if (emaShort[i + (longPeriod - shortPeriod)] !== undefined) {
            macdLine.push(emaShort[i + (longPeriod - shortPeriod)] - emaLong[i]);
        }
    }

    const signalLine = calculateEMA(macdLine, signalPeriod);

    const latestMACD = macdLine[macdLine.length - 1];
    const latestSignal = signalLine[signalLine.length - 1];
    const histogram = latestMACD - latestSignal;

    return {
        macdLine,
        signalLine,
        histogram: isNaN(histogram) ? 0 : histogram
    };
}



function calculateEMA(prices, period) {
    const k = 2 / (period + 1);
    const ema = [];

    let sum = 0;
    for (let i = 0; i < period; i++) {
        sum += prices[i];
    }

    let prevEMA = sum / period;
    ema.push(prevEMA);

    for (let i = period; i < prices.length; i++) {
        const currentEMA = prices[i] * k + prevEMA * (1 - k);
        ema.push(currentEMA);
        prevEMA = currentEMA;
    }

    return ema;
}
