function showPast10Days(data) {
  const sortedDates = Object.keys(data).sort().reverse();
  const $container = $('#pastCardContainer');
  $container.empty();

  let upDays = 0, downDays = 0, neutralDays = 0, totalChange = 0;
  const totalCards = Math.min(24, sortedDates.length - 1);

  for (let i = 0; i < totalCards; i++) {
    const date = sortedDates[i];
    const prevDate = sortedDates[i + 1];

    const close = parseFloat(data[date]["4. close"]);
    const prevClose = parseFloat(data[prevDate]["4. close"]);
    const diff = close - prevClose;
    const percentChange = ((diff / prevClose) * 100).toFixed(2);
    const direction = diff > 0 ? '📈' : diff < 0 ? '📉' : '➖';

    let cardClass = 'neutral';
    if (diff > 0.5) {
      upDays++;
      cardClass = 'positive';
    } else if (diff < -0.5) {
      downDays++;
      cardClass = 'negative';
    } else {
      neutralDays++;
    }

    totalChange += parseFloat(percentChange);

    const card = `
      <div class="past-card ${cardClass}">
        <h4>${date}</h4>
        <p><strong>Close:</strong> ₹${close.toFixed(2)}</p>
        <p><strong>% Change:</strong> ${percentChange}%</p>
        <p><strong>Direction:</strong> ${direction}</p>
      </div>
    `;

    $container.append(card);
  }

  // Determine sentiment  
  let sentiment = "😐 Neutral";
  if (upDays > downDays + neutralDays) {
    sentiment = "📊 Bullish";
  } else if (downDays > upDays + neutralDays) {
    sentiment = "⚠️ Bearish";
  }

  const avgChange = (totalChange / totalCards).toFixed(2);

  const summary = `
    <div class="sentiment-summary">
      <h3>📈 Market Sentiment (Last ${totalCards} Days)</h3>
      <ul>
        <li><strong>Up Days:</strong> ${upDays}</li>
        <li><strong>Down Days:</strong> ${downDays}</li>
        <li><strong>Neutral Days:</strong> ${neutralDays}</li>
        <li><strong>Average % Change:</strong> ${avgChange}%</li>
      </ul>
  <li class="overall_sentiment"><strong>Overall Sentiment:</strong> The market sentiment for this day is identified as <strong>${sentiment}</strong>, indicating a ${sentiment.includes('Bullish') ? 'positive investor outlook with potential upward momentum' : sentiment.includes('Bearish') ? 'negative investor sentiment suggesting downward pressure' : 'neutral stance with no significant directional bias'}. This analysis is based on the percentage change in closing price and observed price movement patterns.</li>

    </div>

  `;

  $container.append(summary);
}
