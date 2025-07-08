function fetchFundamentalDividentsData(symbol) {
    const apiUrl = `https://financialmodelingprep.com/api/v3/historical-price-full/stock_dividend/${symbol}?apikey=${FMP_API_KEY}`;

    $.ajax({
        url: apiUrl,
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            console.log("FMP Dividend Data Response:", response);

            if (!response || !response.historical || !response.historical.length) {
                $('#fundamentalDataTable tbody').html('<tr><td colspan="4">No dividend data available for this stock.</td></tr>');
                return;
            }

            const tbody = $('#fundamentalDataTable tbody');
            tbody.empty();

            response.historical.forEach(dividend => {
                const row = `<tr>
                    <td>${dividend.date}</td>
                    <td>${dividend.dividend}</td>
                    <td>${dividend.declarationDate || '-'}</td>
                    <td>${dividend.paymentDate || '-'}</td>
                </tr>`;
                tbody.append(row);
            });
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error("Error fetching dividend data:", textStatus, errorThrown);
            $('#fundamentalDataTable tbody').html('<tr><td colspan="4">Error fetching dividend data. Please try again later.</td></tr>');
        }
    });
}


function fetchFundamentalSplitssData(symbol) {
    const apiUrl = `https://financialmodelingprep.com/api/v3/historical-price-full/stock_split/${symbol}?apikey=${FMP_API_KEY}`;

    $.ajax({
        url: apiUrl,
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            console.log("FMP Split Data Response:", response);

            if (!response || !response.historical || !response.historical.length) {
                $('#splitsDataTable tbody').html('<tr><td colspan="3">No split data available for this stock.</td></tr>');
                return;
            }

            const tbody = $('#splitsDataTable tbody');
            tbody.empty();

            response.historical.forEach(split => {
                const row = `<tr>
                    <td>${split.date}</td>
                    <td>${split.numerator}:${split.denominator}</td>
                    <td>${split.label}</td>
                </tr>`;
                tbody.append(row);
            });
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error("Error fetching split data:", textStatus, errorThrown);
            $('#splitsDataTable tbody').html('<tr><td colspan="3">Error fetching split data. Please try again later.</td></tr>');
        }
    });
}


