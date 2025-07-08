// const FMP_API_KEY = "T8HogSezq0WNy97WinOjjLMEOuiKjnu5";

function fetchBalanceSheet(symbol) {
    const apiUrl = `https://financialmodelingprep.com/api/v3/balance-sheet-statement/${symbol}?period=annual&apikey=${FMP_API_KEY}`;

    $.ajax({
        url: apiUrl,
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            console.log("Balance Sheet Data Response:", response);

            if (!response || !response.length) {
                console.warn("No balance sheet data available for this stock.");
                showMessageBox(`No balance sheet data found for ${symbol}.`);
                return;
            }

            const balanceSheets = response;
            const labels = balanceSheets.map(item => item.date);
            const totalAssets = balanceSheets.map(item => parseFloat(item.totalAssets || 0));
            const totalLiabilities = balanceSheets.map(item => parseFloat(item.totalLiabilities || 0));
            const totalEquity = balanceSheets.map(item => parseFloat(item.totalEquity || 0));

            renderBalanceSheetChart(labels, totalAssets, totalLiabilities, totalEquity);
            renderBalanceSheetTable(balanceSheets);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error("AJAX Error (Balance Sheet):", textStatus, errorThrown);
            showMessageBox(`Failed to fetch balance sheet data for ${symbol}. Check network connection or API key.`);
        }
    });
}

function renderBalanceSheetChart(labels, totalAssets, totalLiabilities, totalEquity) {
    const ctx = document.getElementById('balanceSheetChart').getContext('2d');

    if (window.balanceSheetChart && typeof window.balanceSheetChart.destroy === 'function') {
        window.balanceSheetChart.destroy();
    }

    window.balanceSheetChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Total Assets',
                    data: totalAssets,
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Total Liabilities',
                    data: totalLiabilities,
                    backgroundColor: 'rgba(255, 99, 132, 0.6)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Total Equity',
                    data: totalEquity,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Fiscal Date'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Amount ($)'
                    },
                    beginAtZero: true
                }
            }
        }
    });
}

function renderBalanceSheetTable(balanceSheets) {
    const headerRow = document.getElementById('balanceSheetHeaderRow');
    const tableBody = document.getElementById('balanceSheetTableBody');

    balanceSheets.sort((a, b) => new Date(b.date) - new Date(a.date));

    headerRow.innerHTML = '';
    tableBody.innerHTML = '';

    let headerHTML = '<tr><th>Metric/Date</th>';
    balanceSheets.forEach(item => {
        headerHTML += `<th>${item.date}</th>`;
    });
    headerHTML += '</tr>';
    headerRow.innerHTML = headerHTML;

    function generateRow(label, getValueWithIcon) {
        let rowHTML = `<tr><td>${label}</td>`;
        balanceSheets.forEach((item, index) => {
            rowHTML += `<td>${getValueWithIcon(item, index)}</td>`;
        });
        rowHTML += '</tr>';
        return rowHTML;
    }

    const rows = [
        {
            label: 'Total Assets ($)',
            getValue: (item, index) => {
                const icon = index > 0 && item.totalAssets > balanceSheets[index - 1].totalAssets
                    ? '<i class="fas fa-arrow-up text-success"></i>'
                    : '<i class="fas fa-arrow-down text-danger"></i>';
                return `${(item.totalAssets / 1e9).toFixed(2)} B ${icon}`;
            }
        },
        {
            label: 'Total Liabilities ($)',
            getValue: (item, index) => {
                const icon = index > 0 && item.totalLiabilities > balanceSheets[index - 1].totalLiabilities
                    ? '<i class="fas fa-arrow-up text-danger"></i>'
                    : '<i class="fas fa-arrow-down text-success"></i>';
                return `${(item.totalLiabilities / 1e9).toFixed(2)} B ${icon}`;
            }
        },
        {
            label: 'Total Equity ($)',
            getValue: (item, index) => {
                const icon = index > 0 && item.totalEquity > balanceSheets[index - 1].totalEquity
                    ? '<i class="fas fa-arrow-up text-success"></i>'
                    : '<i class="fas fa-arrow-down text-danger"></i>';
                return `${(item.totalEquity / 1e9).toFixed(2)} B ${icon}`;
            }
        },
        {
            label: 'Current Assets ($)',
            getValue: (item, index) => {
                const icon = index > 0 && item.totalCurrentAssets > balanceSheets[index - 1].totalCurrentAssets
                    ? '<i class="fas fa-arrow-up text-success"></i>'
                    : '<i class="fas fa-arrow-down text-danger"></i>';
                return `${(item.totalCurrentAssets / 1e9).toFixed(2)} B ${icon}`;
            }
        },
        {
            label: 'Current Liabilities ($)',
            getValue: (item, index) => {
                const icon = index > 0 && item.totalCurrentLiabilities > balanceSheets[index - 1].totalCurrentLiabilities
                    ? '<i class="fas fa-arrow-up text-danger"></i>'
                    : '<i class="fas fa-arrow-down text-success"></i>';
                return `${(item.totalCurrentLiabilities / 1e9).toFixed(2)} B ${icon}`;
            }
        }
    ];

    rows.forEach(row => {
        tableBody.innerHTML += generateRow(row.label, row.getValue);
    });
}

$('#stockSelector').on('change', function () {
    const selectedSymbol = this.value;
    fetchBalanceSheet(selectedSymbol);
});
