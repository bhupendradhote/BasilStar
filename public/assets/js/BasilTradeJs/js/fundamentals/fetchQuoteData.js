function fetchQuoteData(symbol) {
    const apiUrl = `https://api.twelvedata.com/quote?symbol=${symbol}&apikey=${TWELVE_DATA_API_KEY}`;

    $.ajax({
        url: apiUrl,
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            console.log("Quote Data Response:", response);

            if (response.status === 'error') {
                console.error("Error fetching quote data:", response.message);
                showMessageBox(`Error fetching quote data for ${symbol}: ${response.message}`);
                return;
            }

            if (!response || !response.symbol) {
                console.warn("No quote data available.");
                showMessageBox(`No quote data found for ${symbol}.`);
                return;
            }

            // Update the chart header
            updateChartHeader(response);

            // Render the quote data
            renderQuoteData(response);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error("AJAX Error (Quote):", textStatus, errorThrown);
            showMessageBox(`Failed to fetch quote data for ${symbol}. Please try again later.`);
        }
    });
}

function renderQuoteData(data) {
    // Update current market data
    $('#latestOpen').text(data.open || 'N/A');
    $('#latestHigh').text(data.high || 'N/A');
    $('#latestLow').text(data.low || 'N/A');
    $('#latestClose').text(data.close || 'N/A');
    $('#latestVolume').text(data.volume ? parseInt(data.volume).toLocaleString() : 'N/A');

    // Update 52-week range
    if (data.fifty_two_week) {
        $('#fiftyTwoWeekLow').text(data.fifty_two_week.low || 'N/A');
        $('#fiftyTwoWeekHigh').text(data.fifty_two_week.high || 'N/A');
        $('#fiftyTwoWeekRange').text(data.fifty_two_week.range || 'N/A');
    } else {
        $('#fiftyTwoWeekLow').text('N/A');
        $('#fiftyTwoWeekHigh').text('N/A');
        $('#fiftyTwoWeekRange').text('N/A');
    }

    // Update market status
    const marketStatus = data.is_market_open ? 'Open' : 'Closed';
    $('#marketStatus').text(marketStatus);

    // Update change and percent change
    updateValueWithColor('#priceChange', data.change);
    updateValueWithColor('#percentChange', data.percent_change ? `${data.percent_change}%` : 'N/A');

    // Update extended trading data
    updateValueWithColor('#extendedPrice', data.extended_price);
    updateValueWithColor('#extendedChange', data.extended_change);
    updateValueWithColor('#extendedPercentChange', data.extended_percent_change ? `${data.extended_percent_change}%` : 'N/A');
}

function updateValueWithColor(selector, value) {
    const element = $(selector);

    if (value === null || value === undefined || value === 'N/A') {
        element.text('N/A').removeClass('positive negative');
        return;
    }

    const numericValue = parseFloat(value);

    if (numericValue < 0) {
        element.text(value).removeClass('positive').addClass('negative');
    } else {
        element.text(value).removeClass('negative').addClass('positive');
    }
}

function updateChartHeader(data) {
    const stockSymbol = data.symbol || 'N/A';
    const stockName = data.name || 'N/A';
    const stockPrice = data.close || 'N/A';
    const priceChange = data.change || 'N/A';
    const percentChange = data.percent_change ? `${data.percent_change}%` : 'N/A';
    const lastUpdated = data.datetime ? new Date(data.datetime).toLocaleString('en-GB', { day: '2-digit', month: 'short', hour: '2-digit', minute: '2-digit' }) : 'N/A';

    // Update the chart title
    $('#chartTitle').html(`
        <span style="font-weight: 100;">${stockSymbol}</span> ₹${stockPrice} 
        <span style="font-size: 12px; color: ${parseFloat(data.percent_change) < 0 ? 'red' : 'green'};">${priceChange} (${percentChange})</span>
        <p style="margin-top:10px;">${stockName} ${lastUpdated}</p>
    `);
}