function fetchEarningsData(symbol) {
    const apiUrl = `https://financialmodelingprep.com/api/v3/historical/earning_calendar/${symbol}?apikey=${FMP_API_KEY}`;
    console.log("FMP Earnings API URL:", apiUrl);

    $.ajax({
        url: apiUrl,
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            if (!Array.isArray(response) || response.length === 0) {
                console.warn("No earnings data available for this stock.");
                showMessageBox(`No earnings data found for ${symbol}.`);
                return;
            }

            renderEarningsTable(response);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error("AJAX Error (Earnings):", textStatus, errorThrown);
            showMessageBox(`Failed to fetch earnings data for ${symbol}. Check network connection or API key.`);
        }
    });
}


function renderEarningsTable(earnings) {
    const tableHead = document.getElementById('earningsTableHead');
    const tableBody = document.getElementById('earningsTableBody');

    // Clear existing content
    tableHead.innerHTML = '';
    tableBody.innerHTML = '';

    // Add table headers
    const headerRow = `
        <tr>
            <th>Date</th>
            <th>Time</th>
            <th>EPS Estimate</th>
            <th>EPS Actual</th>
            <th>Revenue Estimate</th>
            <th>Revenue Actual</th>
            <th>Fiscal Period</th>
        </tr>
    `;
    tableHead.innerHTML = headerRow;

    // Add table rows
    let rows = '';
    earnings.forEach(item => {
        rows += `
            <tr>
                <td>${item.date || 'N/A'}</td>
                <td>${item.time || 'Time Not Supplied'}</td>
                <td>${item.epsEstimated !== null ? item.epsEstimated : 'N/A'}</td>
                <td>${item.eps !== null ? item.eps : 'N/A'}</td>
                <td>${item.revenueEstimated !== null ? formatNumber(item.revenueEstimated) : 'N/A'}</td>
                <td>${item.revenue !== null ? formatNumber(item.revenue) : 'N/A'}</td>
                <td>${item.fiscalDateEnding || 'N/A'}</td>
            </tr>
        `;
    });

    if (rows === '') {
        rows = `
            <tr>
                <td colspan="7">No earnings data available.</td>
            </tr>
        `;
    }

    tableBody.innerHTML = rows;
}

function formatNumber(number) {
    if (!number) return 'N/A';
    return Number(number).toLocaleString("en-US", { maximumFractionDigits: 2 });
}


