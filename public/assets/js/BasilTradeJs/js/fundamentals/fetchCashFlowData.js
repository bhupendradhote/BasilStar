// const FMP_API_KEY = "T8HogSezq0WNy97WinOjjLMEOuiKjnu5";


function fetchCashFlow(symbol) {
    const apiUrl = `https://financialmodelingprep.com/api/v3/cash-flow-statement-growth/${symbol}?period=annual&apikey=${FMP_API_KEY}`;

    $.ajax({
        url: apiUrl,
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            console.log("FMP Cash Flow Growth Response:", response);

            if (!response || response.length === 0) {
                console.warn("No growth cash flow data found.");
                showMessageBox(`No cash flow data found for ${symbol}.`);
                return;
            }

            const data = response;

            const labels = data.map(item => item.calendarYear);
            const operatingCashFlow = data.map(item => item.growthOperatingCashFlow || 0);
            const investingCashFlow = data.map(item => item.growthNetCashUsedForInvestingActivites || 0);
            const financingCashFlow = data.map(item => item.growthNetCashUsedProvidedByFinancingActivities || 0);
            const freeCashFlow = data.map(item => item.growthFreeCashFlow || 0);
            const netIncome = data.map(item => item.growthNetIncome || 0);

            // Convert % change for display (e.g., 0.05 -> 5%)
            const scale = arr => arr.map(x => x * 100);

            renderCashFlowChart(labels, scale(operatingCashFlow), scale(investingCashFlow), scale(financingCashFlow));
            renderFreeCashFlowChart(labels, scale(freeCashFlow), scale(netIncome));
            renderCashFlowTable(labels, scale(operatingCashFlow), scale(investingCashFlow), scale(financingCashFlow), scale(freeCashFlow), scale(netIncome));
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error("AJAX Error (Cash Flow):", textStatus, errorThrown);
            showMessageBox(`Failed to fetch cash flow data for ${symbol}.`);
        }
    });
}


function renderCashFlowChart(labels, operatingCashFlow, investingCashFlow, financingCashFlow) {
    const canvas = document.getElementById('cashFlowChart');
    if (!canvas) {
        console.error("Canvas with id 'cashFlowChart' not found.");
        return;
    }

    const ctx = canvas.getContext('2d');

    if (window.cashFlowChart && typeof window.cashFlowChart.destroy === 'function') {
        window.cashFlowChart.destroy();
    }

    window.cashFlowChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Operating Cash Flow (%)',
                    data: operatingCashFlow,
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Investing Cash Flow (%)',
                    data: investingCashFlow,
                    backgroundColor: 'rgba(255, 159, 64, 0.6)',
                    borderColor: 'rgba(255, 159, 64, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Financing Cash Flow (%)',
                    data: financingCashFlow,
                    backgroundColor: 'rgba(153, 102, 255, 0.6)',
                    borderColor: 'rgba(153, 102, 255, 1)',
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
                        text: 'Fiscal Year'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Growth (%)'
                    },
                    beginAtZero: true
                }
            }
        }
    });
}


function renderFreeCashFlowChart(labels, freeCashFlow, netIncome) {
    const ctx = document.getElementById('freeCashFlowChart').getContext('2d');

    // Destroy existing chart instance if it exists
    if (window.freeCashFlowChart && typeof window.freeCashFlowChart.destroy === 'function') {
        window.freeCashFlowChart.destroy();
    }

    // Create a new chart
    window.freeCashFlowChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Free Cash Flow',
                    data: freeCashFlow,
                    borderColor: 'rgba(54, 162, 235, 1)',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'Net Income',
                    data: netIncome,
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
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


function renderCashFlowTable(labels, operatingCashFlow, investingCashFlow, financingCashFlow, freeCashFlow, netIncome) {
    const tableHead = document.getElementById('cashFlowTableHead');
    const tableBody = document.getElementById('cashFlowTableBody');

    // Clear existing content
    tableHead.innerHTML = '';
    tableBody.innerHTML = '';

    const toCr = num => (num / 1e7).toFixed(2) + ' Cr';

    // Add date headers (top row)
    let headerRow = '<tr><th>Metric/Date</th>';
    labels.forEach(label => {
        headerRow += `<th>${label}</th>`;
    });
    headerRow += '</tr>';
    tableHead.innerHTML = headerRow;

    // Helper to generate rows with icons
    const createRowWithIcons = (title, dataArray) => {
        let row = `<tr><td>${title}</td>`;
        dataArray.forEach((value, index) => {
            let icon = '';
            if (index > 0) {
                if (value > dataArray[index - 1]) {
                    icon = `<i class="fas fa-arrow-up" style="color: green; margin-left: 5px;"></i>`;
                } else if (value < dataArray[index - 1]) {
                    icon = `<i class="fas fa-arrow-down" style="color: red; margin-left: 5px;"></i>`;
                }
            }
            row += `<td>${toCr(value)} ${icon}</td>`;
        });
        row += '</tr>';
        return row;
    };

    // Create all metric rows
    let rows = '';
    rows += createRowWithIcons('Operating Cash Flow (₹)', operatingCashFlow);
    rows += createRowWithIcons('Investing Cash Flow (₹)', investingCashFlow);
    rows += createRowWithIcons('Financing Cash Flow (₹)', financingCashFlow);
    rows += createRowWithIcons('Free Cash Flow (₹)', freeCashFlow);
    rows += createRowWithIcons('Net Income (₹)', netIncome);

    tableBody.innerHTML = rows;
}


document.addEventListener("DOMContentLoaded", function () {
    fetchCashFlow(symbol); // call here instead of top-level
});
