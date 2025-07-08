// ✅ Replace old API URL with FMP API
function fetchIncomeStatement(symbol) {
    const apiUrl = `https://financialmodelingprep.com/api/v3/income-statement/${symbol}?period=annual&apikey=T8HogSezq0WNy97WinOjjLMEOuiKjnu5`;

    $.ajax({
        url: apiUrl,
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            console.log("Income Statement Data Response:", response);

            if (!response || response.length === 0) {
                console.warn("No income statement data available for this stock.");
                showMessageBox(`No income statement data found for ${symbol}.`);
                return;
            }

            const incomeStatements = response;
            const labels = incomeStatements.map(item => item.date);
            const sales = incomeStatements.map(item => parseFloat(item.revenue || 0));
            const grossProfit = incomeStatements.map(item => parseFloat(item.grossProfit || 0));
            const netIncome = incomeStatements.map(item => parseFloat(item.netIncome || 0));
            const operatingIncome = incomeStatements.map(item => parseFloat(item.operatingIncome || 0));
            const ebitda = incomeStatements.map(item => parseFloat(item.ebitda || 0));

            renderCombinedChart(labels, sales, grossProfit, netIncome);
            renderOperatingIncomeChart(labels, operatingIncome, ebitda);
            renderIncomeStatementTable(labels, sales, grossProfit, netIncome, operatingIncome, ebitda);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error("AJAX Error (Income Statement):", textStatus, errorThrown);
            showMessageBox(`Failed to fetch income statement data for ${symbol}. Check network connection or API key.`);
        }
    });
}

function renderCombinedChart(labels, sales, grossProfit, netIncome) {
    const ctx = document.getElementById('combinedChart').getContext('2d');
    if (window.combinedChart && typeof window.combinedChart.destroy === 'function') {
        window.combinedChart.destroy();
    }

    window.combinedChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Sales',
                    data: sales,
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    type: 'bar'
                },
                {
                    label: 'Gross Profit',
                    data: grossProfit,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    type: 'bar'
                },
                {
                    label: 'Net Income',
                    data: netIncome,
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderWidth: 2,
                    type: 'line',
                    tension: 0.4,
                    fill: false
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
                        text: 'Amount (in ₹)'
                    },
                    beginAtZero: true
                }
            }
        }
    });
}

function renderOperatingIncomeChart(labels, operatingIncome, ebitda) {
    const ctx = document.getElementById('operatingIncomeChart').getContext('2d');
    if (window.operatingIncomeChart && typeof window.operatingIncomeChart.destroy === 'function') {
        window.operatingIncomeChart.destroy();
    }

    window.operatingIncomeChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Operating Income',
                    data: operatingIncome,
                    borderColor: 'rgba(153, 102, 255, 1)',
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'EBITDA',
                    data: ebitda,
                    borderColor: 'rgba(255, 159, 64, 1)',
                    backgroundColor: 'rgba(255, 159, 64, 0.2)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true
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
                        text: 'Amount (in ₹)'
                    },
                    beginAtZero: true
                }
            }
        }
    });
}

function renderIncomeStatementTable(labels, sales, grossProfit, netIncome, operatingIncome, ebitda) {
    const tableHead = document.getElementById('incomeStatementTableHead');
    const tableBody = document.getElementById('incomeStatementTableBody');
    tableHead.innerHTML = '';
    tableBody.innerHTML = '';

    const toCr = num => (num / 1e7).toFixed(2) + ' Cr';

    let headerRow = '<tr><th>Metric/Date</th>';
    labels.forEach(label => {
        headerRow += `<th>${label}</th>`;
    });
    headerRow += '</tr>';
    tableHead.innerHTML = headerRow;

    const getIcon = (arr, i) => {
        if (i === 0) return '';
        return arr[i] > arr[i - 1]
            ? '<i class="fas fa-arrow-up increase-icon"></i>'
            : '<i class="fas fa-arrow-down decrease-icon"></i>';
    };

    const createRow = (title, dataArray) => {
        let row = `<tr><td>${title}</td>`;
        dataArray.forEach((value, i) => {
            row += `<td>${toCr(value)} ${getIcon(dataArray, i)}</td>`;
        });
        row += '</tr>';
        return row;
    };

    let rows = '';
    rows += createRow('Sales (₹)', sales);
    rows += createRow('Gross Profit (₹)', grossProfit);
    rows += createRow('Net Income (₹)', netIncome);
    rows += createRow('Operating Income (₹)', operatingIncome);
    rows += createRow('EBITDA (₹)', ebitda);

    tableBody.innerHTML = rows;
}

// 🔁 Attach to dropdown listener
$('#stockSelector').on('change', function () {
    const selectedSymbol = this.value;
    fetchIncomeStatement(selectedSymbol);
});
