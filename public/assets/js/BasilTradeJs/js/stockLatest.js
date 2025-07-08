function showLatestDetails(data, symbol) {
    const sortedDates = Object.keys(data).sort();
    const latestDate = sortedDates[sortedDates.length - 1];
    const latest = data[latestDate];
  
    $('#latestTitle').text(`${symbol} - ${latestDate}`);
    $('#latestOpen').text(parseFloat(latest["1. open"]).toFixed(2));
    $('#latestHigh').text(parseFloat(latest["2. high"]).toFixed(2));
    $('#latestLow').text(parseFloat(latest["3. low"]).toFixed(2));
    $('#latestClose').text(parseFloat(latest["4. close"]).toFixed(2));
    $('#latestVolume').text(Number(latest["5. volume"]).toLocaleString());
  }
  