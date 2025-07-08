// utils/stockChangeDescription.js

function generateStockChangeDescriptions(dates, prices) {
    if (!dates.length || !prices.length || dates.length !== prices.length) return;
  
    const latestClose = prices[prices.length - 1];
    const latestDate = new Date(dates[dates.length - 1]);
  
    function getClosePriceBefore(daysAgo) {
      const targetTime = latestDate.getTime() - daysAgo * 24 * 60 * 60 * 1000;
      for (let i = dates.length - 1; i >= 0; i--) {
        const d = new Date(dates[i]);
        if (d.getTime() <= targetTime) return prices[i];
      }
      return prices[0]; // fallback
    }
  
    function calculateChangeText(pastPrice, label) {
      const change = ((latestClose - pastPrice) / pastPrice) * 100;
      const direction = change >= 0 ? "up" : "down";
      return `This stock is ${direction} by ${Math.abs(change).toFixed(2)}% this ${label}.`;
    }
  
    const description = {
      daily: calculateChangeText(getClosePriceBefore(1), "day"),
      weekly: calculateChangeText(getClosePriceBefore(7), "week"),
      monthly: calculateChangeText(getClosePriceBefore(30), "month"),
      yearly: calculateChangeText(getClosePriceBefore(365), "year")
    };
  
    return description;
  }

  function checkMovingAverage(dates, prices, period) {
    if (prices.length < period) {
      return `Not enough data to calculate ${period}-day moving average.`;
    }
  
    const recentPrice = prices[prices.length - 1];
    const recentPrices = prices.slice(-period);
    const movingAverage = recentPrices.reduce((a, b) => a + b, 0) / period;
  
    const diff = ((recentPrice - movingAverage) / movingAverage * 100).toFixed(2);
    const absDiff = Math.abs(diff);
  
    if (recentPrice > movingAverage) {
      return `Current price is <strong>${diff}%</strong> <span style="color: #4caf50;">above</span> the ${period}-day moving average.`;
    } else if (recentPrice < movingAverage) {
      return `Current price is <strong>${absDiff}%</strong> <span style="color: #f44336;">below</span> the ${period}-day moving average.`;
    } else {
      return `Current price is exactly at the ${period}-day moving average.`;
    }
  }

  
  function getSentimentByTimeframe(data) {
    const dates = Object.keys(data).sort();
    const sentiments = {};
  
    const getChange = (startIdx, endIdx) => {
      const startClose = parseFloat(data[dates[startIdx]]["4. close"]);
      const endClose = parseFloat(data[dates[endIdx]]["4. close"]);
      const startVol = parseInt(data[dates[startIdx]]["5. volume"]);
      const endVol = parseInt(data[dates[endIdx]]["5. volume"]);
  
      const priceChange = ((endClose - startClose) / startClose) * 100;
      const volumeChange = ((endVol - startVol) / startVol) * 100;
  
      return { priceChange, volumeChange };
    };
  
    const interpretSentiment = (price, volume) => {
      let sentiment = "➖ Neutral";
      let color = "#ffc107";
      let arrow = "⏸️";
      let comment = "Sideways movement";
  
      if (price > 2 && volume > 20) {
        sentiment = "📈 Strong Buying";
        color = "#4caf50";
        arrow = "↑↑";
        comment = "Heavy buying pressure";
      } else if (price > 0.5 && volume > 5) {
        sentiment = "📈 Buying";
        color = "#8bc34a";
        arrow = "↑";
        comment = "Mild buying interest";
      } else if (price < -2 && volume > 20) {
        sentiment = "📉 Strong Selling";
        color = "#f44336";
        arrow = "↓↓";
        comment = "Heavy selling pressure";
      } else if (price < -0.5 && volume > 5) {
        sentiment = "📉 Selling";
        color = "#ff5722";
        arrow = "↓";
        comment = "Mild selling interest";
      }
  
      return {
        html: `<span style="color: ${color}; font-weight: bold;">${arrow} ${sentiment}</span><br><small style="color: #aaa;">Price: ${price.toFixed(2)}%, Volume: ${volume.toFixed(2)}%<br>${comment}</small>`
      };
    };
  
    const len = dates.length;
  
    const tfMap = {
      "1D": { start: len - 2, end: len - 1 },
      "1W": { start: len - 6, end: len - 1 },
      "1M": { start: len - 21, end: len - 1 },
      "3M": { start: len - 63, end: len - 1 }
    };
  
    for (const [key, { start, end }] of Object.entries(tfMap)) {
      if (start < 0 || end >= len) {
        sentiments[key] = `<span style="color: #ccc;">Not enough data</span>`;
        continue;
      }
  
      const { priceChange, volumeChange } = getChange(start, end);
      sentiments[key] = interpretSentiment(priceChange, volumeChange).html;
    }
  
    return sentiments;
  }
  
  
