// const FMP_API_KEY = 'T8HogSezq0WNy97WinOjjLMEOuiKjnu5';
let marketMoversChart = null;

function showLoader() {
    document.getElementById('marketMoversLoader').style.display = 'flex';
}

function hideLoader() {
    document.getElementById('marketMoversLoader').style.display = 'none';
}

function fetchMarketMoversFromFMP() {
    showLoader();
    const apiUrl = `https://financialmodelingprep.com/api/v3/stock_market/actives?apikey=${FMP_API_KEY}`;

    $.ajax({
        url: apiUrl,
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            hideLoader();

            if (!Array.isArray(response) || response.length === 0) {
                showMessageBox("No market mover data available.");
                return;
            }

            renderMarketMoversTable(response);
            renderMarketMoversGraph(response);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            hideLoader();
            showMessageBox("Failed to fetch market data from FMP.");
            console.error("FMP error:", textStatus, errorThrown);
        }
    });
}

function renderMarketMoversTable(data) {
    const tableHead = document.getElementById('marketMoversTableHead');
    const tableBody = document.getElementById('marketMoversTableBody');

    tableHead.innerHTML = `
        <tr class="res_change_head">
            <th>Symbol</th>
            <th>Name</th>
            <th>Price</th>
            <th>Change</th>
            <th>Percent Change (%)</th>
        </tr>
    `;

    const rows = data.map(item => `
        <tr class="res_change_row">
            <td class="res_sym">${item.symbol || 'N/A'}</td>
            <td>${item.name || 'N/A'}</td>
            <td>${item.price !== null ? item.price.toFixed(2) : 'N/A'}</td>
            <td>${item.change !== null ? item.change.toFixed(2) : 'N/A'}</td>
            <td>${item.changesPercentage !== null ? item.changesPercentage.toFixed(2) : 'N/A'}%</td>
        </tr>
    `).join('');

    tableBody.innerHTML = rows || `<tr><td colspan="5">No data available.</td></tr>`;
}

function renderMarketMoversGraph(data) {
    const labels = data.map(item => item.symbol || 'N/A');
    const prices = data.map(item => item.price || 0);
    const percentChanges = data.map(item => item.changesPercentage || 0);

    const ctx = document.getElementById('marketMoversChart').getContext('2d');

    if (marketMoversChart) {
        marketMoversChart.destroy();
    }

    marketMoversChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Price',
                    data: prices,
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Change (%)',
                    data: percentChanges,
                    backgroundColor: 'rgba(255, 99, 132, 0.6)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top'
                },
                tooltip: {
                    mode: 'index',
                    intersect: false
                }
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Symbol'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Value'
                    }
                }
            }
        }
    });
}

document.addEventListener('DOMContentLoaded', () => {
    fetchMarketMoversFromFMP(); // Initial load
});
