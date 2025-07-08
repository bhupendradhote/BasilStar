let chart;
let fullDates = [];
let fullPrices = [];

function renderStockChart(dates, prices, symbol) {
  fullDates = dates;
  fullPrices = prices;
  updateChart('1y', symbol); // default
}

function updateChart(range, symbol) {
  const now = new Date();
  let cutoffDate;

  switch (range) {
    case '1d':
      cutoffDate = new Date(now.setDate(now.getDate() - 1));
      break;
    case '1w':
      cutoffDate = new Date(now.setDate(now.getDate() - 7));
      break;
    case '1m':
      cutoffDate = new Date(now.setMonth(now.getMonth() - 1));
      break;
    case '3m':
      cutoffDate = new Date(now.setMonth(now.getMonth() - 3));
      break;
    case '1y':
      cutoffDate = new Date(now.setFullYear(now.getFullYear() - 1));
      break;
    case '3y':
      cutoffDate = new Date(now.setFullYear(now.getFullYear() - 3));
      break;
    case '5y':
      cutoffDate = new Date(now.setFullYear(now.getFullYear() - 5));
      break;
    case 'max':
    default:
      cutoffDate = null;
      break;
  }

  let filteredDates = fullDates;
  let filteredPrices = fullPrices;

  if (cutoffDate) {
    filteredDates = fullDates.filter(date => new Date(date) >= cutoffDate);
    filteredPrices = fullPrices.slice(fullDates.length - filteredDates.length);
  }

  const isDown = filteredPrices[filteredPrices.length - 1] < filteredPrices[0];
  const bgColor = isDown ? 'rgba(255, 99, 132, 0.1)' : 'rgba(75, 192, 192, 0.1)';
  const lineColor = isDown ? '#ff6384' : '#4bc0c0';

  const ctx = document.getElementById('stockChart').getContext('2d');
  if (chart) chart.destroy();

  chart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: filteredDates,
      datasets: [{
        label: '',
        data: filteredPrices,
        borderColor: lineColor,
        backgroundColor: bgColor,
        tension: 0.4,
        fill: true,
        pointRadius: 0,
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          display: false
        },
        tooltip: {
          mode: 'index',
          intersect: false
        }
      },
      interaction: {
        mode: 'index',
        intersect: false
      },
      scales: {
        x: {
          title: {
            display: true,
            text: 'Date'
          },
          grid: {
            display: false
          }
        },
        y: {
          position: 'right',
          title: {
            display: true,
            text: 'Price (₹)'
          },
          grid: {
            display: false
          }
        }
      }
    }
  });
}

$('#timeframeSelector button').on('click', function () {
  $('#timeframeSelector button').removeClass('active');
  $(this).addClass('active');

  const range = $(this).data('range');
  const symbol = $('#stockSelector').val();
  updateChart(range, symbol);
});
