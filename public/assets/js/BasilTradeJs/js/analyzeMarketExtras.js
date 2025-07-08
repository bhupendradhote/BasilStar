// === MarketAnalysis.js ===

// Helper: Simple Moving Average
function calculateSMA(prices, period) {
    if (prices.length < period) return 0;
    const sum = prices.slice(-period).reduce((a, b) => a + b, 0);
    return sum / period;
  }
  
  // 1. Bollinger Bands
  function calculateBollingerBands(prices, period = 20, multiplier = 2) {
    const sma = calculateSMA(prices, period);
    const slice = prices.slice(-period);
    const stdDev = Math.sqrt(slice.reduce((acc, p) => acc + Math.pow(p - sma, 2), 0) / period);
    return {
      upper: sma + multiplier * stdDev,
      lower: sma - multiplier * stdDev,
      sma
    };
  }
  
  // 2. ATR (Average True Range)
  function calculateATR(highs, lows, closes, period = 14) {
    let trs = [];
    for (let i = 1; i < highs.length; i++) {
      const high = highs[i];
      const low = lows[i];
      const prevClose = closes[i - 1];
      trs.push(Math.max(
        high - low,
        Math.abs(high - prevClose),
        Math.abs(low - prevClose)
      ));
    }
    return trs.slice(-period).reduce((a, b) => a + b, 0) / period;
  }
  
  // 3. OBV (On-Balance Volume)
  function calculateOBV(closes, volumes) {
    let obv = 0;
    for (let i = 1; i < closes.length; i++) {
      if (closes[i] > closes[i - 1]) obv += volumes[i];
      else if (closes[i] < closes[i - 1]) obv -= volumes[i];
    }
    return obv;
  }
  
  // 4. Candlestick Pattern Detection (basic)
  function detectCandlePattern(data, dates) {
    if (dates.length < 3) return "Not enough data";
  
    const lastDate = dates[dates.length - 1];
    const prevDate = dates[dates.length - 2];
    const prevPrevDate = dates[dates.length - 3];
  
    const last = data[lastDate];
    const prev = data[prevDate];
    const prevPrev = data[prevPrevDate];
  
    if (!last || !prev || !prevPrev) return "Missing candle data";
  
    // Current candle
    const open = parseFloat(last["1. open"]);
    const close = parseFloat(last["4. close"]);
    const high = parseFloat(last["2. high"]);
    const low = parseFloat(last["3. low"]);
    const bodySize = Math.abs(close - open);
    const totalRange = high - low;
    const upperWick = high - Math.max(open, close);
    const lowerWick = Math.min(open, close) - low;
    const isBullish = close > open;
    const isBearish = close < open;
    const bodyMid = (open + close) / 2;
    
    // Previous candle
    const prevOpen = parseFloat(prev["1. open"]);
    const prevClose = parseFloat(prev["4. close"]);
    const prevHigh = parseFloat(prev["2. high"]);
    const prevLow = parseFloat(prev["3. low"]);
    const prevBodySize = Math.abs(prevClose - prevOpen);
    const prevTotalRange = prevHigh - prevLow;
    const prevIsBullish = prevClose > prevOpen;
    const prevIsBearish = prevClose < prevOpen;
    
    // Previous previous candle
    const prevPrevOpen = parseFloat(prevPrev["1. open"]);
    const prevPrevClose = parseFloat(prevPrev["4. close"]);
    const prevPrevHigh = parseFloat(prevPrev["2. high"]);
    const prevPrevLow = parseFloat(prevPrev["3. low"]);
    const prevPrevIsBullish = prevPrevClose > prevPrevOpen;
    const prevPrevIsBearish = prevPrevClose < prevPrevOpen;
    
    // === SINGLE-CANDLE PATTERNS ===
    
    // Doji variations
    if (bodySize <= (totalRange * 0.1)) {
        const isNeutral = Math.abs(close - open) <= (totalRange * 0.05);
        const hasLongWicks = (upperWick > totalRange * 0.4) && (lowerWick > totalRange * 0.4);
        
        if (isNeutral && hasLongWicks) {
            return "Long-Legged Doji (Strong Indecision)";
        }
        if (upperWick > totalRange * 0.6) {
            return "Gravestone Doji (Bearish Reversal)";
        }
        if (lowerWick > totalRange * 0.6) {
            return "Dragonfly Doji (Bullish Reversal)";
        }
        return "Doji (Indecision)";
    }
    
    // Hammer variations
    if (isBullish && (lowerWick > bodySize * 2) && (upperWick < bodySize * 0.5)) {
        if (prevIsBearish) return "Hammer (Bullish Reversal)";
        return "Bullish Hammer";
    }
    
    // Inverted Hammer variations
    if (isBullish && (upperWick > bodySize * 2) && (lowerWick < bodySize * 0.5)) {
        if (prevIsBearish) return "Inverted Hammer (Potential Bullish Reversal)";
        return "Inverted Hammer";
    }
    
    // Shooting Star
    if (isBearish && (upperWick > bodySize * 2) && (lowerWick < bodySize * 0.5)) {
        if (prevIsBullish) return "Shooting Star (Bearish Reversal)";
        return "Shooting Star";
    }
    
    // Hanging Man
    if (isBearish && (lowerWick > bodySize * 2) && (upperWick < bodySize * 0.5)) {
        if (prevIsBullish) return "Hanging Man (Bearish Reversal)";
        return "Hanging Man";
    }
    
    // Marubozu (no wicks)
    if (bodySize > totalRange * 0.9) {
        if (isBullish) return "Bullish Marubozu (Strong Buying Pressure)";
        if (isBearish) return "Bearish Marubozu (Strong Selling Pressure)";
    }
    
    // Spinning Top
    if (bodySize <= totalRange * 0.3 && 
        upperWick >= totalRange * 0.3 && 
        lowerWick >= totalRange * 0.3) {
        return "Spinning Top (Indecision)";
    }
    
    // === TWO-CANDLE PATTERNS ===
    
    // Engulfing patterns
    if (isBullish && prevIsBearish &&
        open <= prevClose && close >= prevOpen) {
        if (bodySize > prevBodySize * 1.5) {
            return "Bullish Engulfing (Strong Reversal)";
        }
        return "Bullish Engulfing";
    }
    
    if (isBearish && prevIsBullish &&
        open >= prevClose && close <= prevOpen) {
        if (bodySize > prevBodySize * 1.5) {
            return "Bearish Engulfing (Strong Reversal)";
        }
        return "Bearish Engulfing";
    }
    
    // Harami patterns
    if (isBullish && prevIsBearish &&
        open > prevClose && close < prevOpen &&
        bodySize < prevBodySize * 0.7) {
        return "Bullish Harami (Potential Reversal)";
    }
    
    if (isBearish && prevIsBullish &&
        open < prevClose && close > prevOpen &&
        bodySize < prevBodySize * 0.7) {
        return "Bearish Harami (Potential Reversal)";
    }
    
    // Piercing Line
    if (isBullish && prevIsBearish &&
        open < prevClose && close > (prevOpen + prevClose)/2) {
        return "Piercing Line (Bullish Reversal)";
    }
    
    // Dark Cloud Cover
    if (isBearish && prevIsBullish &&
        open > prevClose && close < (prevOpen + prevClose)/2) {
        return "Dark Cloud Cover (Bearish Reversal)";
    }
    
    // Tweezer patterns
    if (Math.abs(high - prevHigh) <= (high * 0.005)) { // 0.5% tolerance
        if (isBearish && prevIsBullish) return "Tweezer Top (Bearish Reversal)";
        if (isBullish && prevIsBearish) return "Tweezer Bottom (Bullish Reversal)";
    }
    
    if (Math.abs(low - prevLow) <= (low * 0.005)) { // 0.5% tolerance
        if (isBullish && prevIsBearish) return "Tweezer Bottom (Bullish Reversal)";
        if (isBearish && prevIsBullish) return "Tweezer Top (Bearish Reversal)";
    }
    
    // === THREE-CANDLE PATTERNS ===
    
    // Morning Star variations
    if (prevPrevIsBearish && 
        (prevBodySize <= prevTotalRange * 0.3) &&
        isBullish && close > prevPrevClose) {
        
        if (prevClose === prevOpen) {
            return "Morning Doji Star (Strong Bullish Reversal)";
        }
        if (close > (prevPrevOpen + prevPrevClose)/2) {
            return "Morning Star (Bullish Reversal)";
        }
    }
    
    // Evening Star variations
    if (prevPrevIsBullish && 
        (prevBodySize <= prevTotalRange * 0.3) &&
        isBearish && close < prevPrevClose) {
        
        if (prevClose === prevOpen) {
            return "Evening Doji Star (Strong Bearish Reversal)";
        }
        if (close < (prevPrevOpen + prevPrevClose)/2) {
            return "Evening Star (Bearish Reversal)";
        }
    }
    
    // Three White Soldiers
    if (isBullish && prevIsBullish && prevPrevIsBullish &&
        open > prevOpen && prevOpen > prevPrevOpen &&
        close > prevClose && prevClose > prevPrevClose &&
        bodySize > totalRange * 0.7) {
        return "Three White Soldiers (Strong Bullish Trend)";
    }
    
    // Three Black Crows
    if (isBearish && prevIsBearish && prevPrevIsBearish &&
        open < prevOpen && prevOpen < prevPrevOpen &&
        close < prevClose && prevClose < prevPrevClose &&
        bodySize > totalRange * 0.7) {
        return "Three Black Crows (Strong Bearish Trend)";
    }
    
    // Advance Block
    if (isBullish && prevIsBullish && prevPrevIsBullish &&
        bodySize < prevBodySize && prevBodySize < prevPrevBodySize &&
        upperWick > bodySize * 0.5) {
        return "Advance Block (Bullish Exhaustion)";
    }
    
    // Deliberation
    if (isBullish && prevIsBullish && prevPrevIsBullish &&
        bodySize < prevBodySize && prevBodySize < prevPrevBodySize &&
        open === close) {
        return "Deliberation (Potential Reversal)";
    }
    
    // === FOUR+ CANDLE PATTERNS (if we have enough data) ===
    if (dates.length >= 4) {
        const prevPrevPrevDate = dates[dates.length - 4];
        const prevPrevPrev = data[prevPrevPrevDate];
        
        if (prevPrevPrev) {
            const prevPrevPrevOpen = parseFloat(prevPrevPrev["1. open"]);
            const prevPrevPrevClose = parseFloat(prevPrevPrev["4. close"]);
            const prevPrevPrevIsBullish = prevPrevPrevClose > prevPrevPrevOpen;
            const prevPrevPrevIsBearish = prevPrevPrevClose < prevPrevPrevOpen;
            
            // Three Inside Up/Down
            if (prevPrevIsBearish && 
                isBullish && prevIsBullish && 
                prevOpen > prevPrevClose && close > prevPrevOpen) {
                return "Three Inside Up (Bullish Reversal)";
            }
            
            if (prevPrevIsBullish && 
                isBearish && prevIsBearish && 
                prevOpen < prevPrevClose && close < prevPrevOpen) {
                return "Three Inside Down (Bearish Reversal)";
            }
            
            // Stick Sandwich
            if (prevPrevIsBullish && prevIsBearish && isBullish &&
                Math.abs(prevPrevClose - close) <= (prevPrevClose * 0.005) &&
                prevLow < prevPrevLow && prevLow < low) {
                return "Stick Sandwich (Bullish Reversal)";
            }
        }
    }
    
    return "None";
}
  

  
  // 5. Sentiment Score Based on Indicators
  function calculateMarketSentiment(buy, sell) {
    const score = buy - sell;
    if (score >= 3) return "🔥 Strong Buy";
    if (score <= -3) return "⚠️ Strong Sell";
    return "⏳ Neutral";
  }
  
  // === Rendering function ===
  function renderMarketIndicators({ bollinger, atr, obv, candle, sentiment }) {
    $("#bollingerValue").text(`Upper: ${bollinger.upper.toFixed(2)}, Lower: ${bollinger.lower.toFixed(2)}`);
    $("#atrValue").text(atr.toFixed(2));
    $("#obvValue").text(obv);
    $("#candleValue").text(candle);
    $("#sentimentValue").text(sentiment);
  }
  
  
  // === Hook into your stock loader ===
  function analyzeMarketExtras(data, dates) {
    const closes = dates.map(d => parseFloat(data[d]["4. close"]));
    const highs = dates.map(d => parseFloat(data[d]["2. high"]));
    const lows = dates.map(d => parseFloat(data[d]["3. low"]));
    const volumes = dates.map(d => parseFloat(data[d]["5. volume"]));
  
    const bollinger = calculateBollingerBands(closes);
    const atr = calculateATR(highs, lows, closes);
    const obv = calculateOBV(closes, volumes);
    const candle = detectCandlePattern(data, dates);
    const sentiment = calculateMarketSentiment(3, 1); // Replace with actual buy/sell count
  
    renderMarketIndicators({ bollinger, atr, obv, candle, sentiment });
  }
  