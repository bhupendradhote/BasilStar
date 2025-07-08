function fetchStockStatistics(symbol) {
    const statisticsApiUrl = `https://financialmodelingprep.com/api/v3/key-metrics-ttm/${symbol}?apikey=T8HogSezq0WNy97WinOjjLMEOuiKjnu5`;

    $.ajax({
        url: statisticsApiUrl,
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            console.log("Raw FinancialModelingPrep Statistics Response:", response);

            if (!response || response.length === 0) {
                console.warn("No statistics data received from FinancialModelingPrep for symbol:", symbol);
                showMessageBox(`No detailed statistics found for ${symbol}.`);
                clearStatisticsDisplay();
                return;
            }

            const statistics = response[0];
            if (!statistics) {
                console.warn("No valid statistics object found in FinancialModelingPrep response for symbol:", symbol);
                showMessageBox(`No detailed statistics found for ${symbol}.`);
                clearStatisticsDisplay();
                return;
            }

            displayStockStatistics(statistics);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error("AJAX Error (Statistics):", textStatus, errorThrown);
            showMessageBox(`Failed to fetch stock statistics data for ${symbol}. Check network connection or API key.`);
            clearStatisticsDisplay();
        }
    });
}

function displayStockStatistics(statistics) {
    const getValue = (obj, path) => {
        const parts = path.split('.');
        let current = obj;
        for (const part of parts) {
            if (current === null || typeof current !== 'object' || !(part in current)) {
                return '-';
            }
            current = current[part];
        }
        if (typeof current === 'number') {
            if (current > 1000) {
                return current.toLocaleString();
            }
            return current;
        }
        return current !== null && current !== undefined ? current : '-';
    };

    clearStatisticsDisplay();

    // Valuation Metrics
    $('#marketCapitalization').text(getValue(statistics, 'marketCapTTM'));
    $('#enterpriseValue').text(getValue(statistics, 'enterpriseValueTTM'));
    $('#trailingPE').text(getValue(statistics, 'peRatioTTM'));
    $('#priceToSalesTTM').text(getValue(statistics, 'priceToSalesRatioTTM'));
    $('#priceToBookMRQ').text(getValue(statistics, 'pbRatioTTM'));
    $('#enterpriseToRevenue').text(getValue(statistics, 'evToSalesTTM'));
    $('#enterpriseToEBITDA').text(getValue(statistics, 'enterpriseValueOverEBITDATTM'));
    $('#priceToOperatingCashFlow').text(getValue(statistics, 'pocfratioTTM'));
    $('#priceToFreeCashFlow').text(getValue(statistics, 'pfcfRatioTTM'));
    $('#earningsYield').text(getValue(statistics, 'earningsYieldTTM'));
    $('#freeCashFlowYield').text(getValue(statistics, 'freeCashFlowYieldTTM'));

    // Financial Health
    $('#currentRatio').text(getValue(statistics, 'currentRatioTTM'));
    $('#debtToEquity').text(getValue(statistics, 'debtToEquityTTM'));
    $('#debtToAssets').text(getValue(statistics, 'debtToAssetsTTM'));
    $('#netDebtToEBITDA').text(getValue(statistics, 'netDebtToEBITDATTM'));
    $('#interestCoverage').text(getValue(statistics, 'interestCoverageTTM'));

    // Profitability
    $('#profitMargin').text((getValue(statistics, 'netIncomePerShareTTM') / getValue(statistics, 'revenuePerShareTTM')).toFixed(4));
    $('#returnOnEquity').text(getValue(statistics, 'roeTTM'));
    $('#returnOnTangibleAssets').text(getValue(statistics, 'returnOnTangibleAssetsTTM'));
    $('#returnOnInvestedCapital').text(getValue(statistics, 'roicTTM'));
    $('#incomeQuality').text(getValue(statistics, 'incomeQualityTTM'));

    // Income Statement
    $('#revenuePerShare').text(getValue(statistics, 'revenuePerShareTTM'));
    $('#netIncomePerShare').text(getValue(statistics, 'netIncomePerShareTTM'));
    $('#operatingCashFlowPerShare').text(getValue(statistics, 'operatingCashFlowPerShareTTM'));
    $('#freeCashFlowPerShare').text(getValue(statistics, 'freeCashFlowPerShareTTM'));
    $('#researchAndDevelopementToRevenue').text(getValue(statistics, 'researchAndDevelopementToRevenueTTM'));
    $('#stockBasedCompensationToRevenue').text(getValue(statistics, 'stockBasedCompensationToRevenueTTM'));

    // Balance Sheet
    $('#cashPerShare').text(getValue(statistics, 'cashPerShareTTM'));
    $('#bookValuePerShare').text(getValue(statistics, 'bookValuePerShareTTM'));
    $('#tangibleBookValuePerShare').text(getValue(statistics, 'tangibleBookValuePerShareTTM'));
    $('#interestDebtPerShare').text(getValue(statistics, 'interestDebtPerShareTTM'));
    $('#debtToMarketCap').text(getValue(statistics, 'debtToMarketCapTTM'));
    $('#workingCapital').text(getValue(statistics, 'workingCapitalTTM'));
    $('#tangibleAssetValue').text(getValue(statistics, 'tangibleAssetValueTTM'));
    $('#netCurrentAssetValue').text(getValue(statistics, 'netCurrentAssetValueTTM'));
    $('#investedCapital').text(getValue(statistics, 'investedCapitalTTM'));

    // Efficiency Metrics
    $('#daysSalesOutstanding').text(getValue(statistics, 'daysSalesOutstandingTTM'));
    $('#daysPayablesOutstanding').text(getValue(statistics, 'daysPayablesOutstandingTTM'));
    $('#daysOfInventoryOnHand').text(getValue(statistics, 'daysOfInventoryOnHandTTM'));
    $('#receivablesTurnover').text(getValue(statistics, 'receivablesTurnoverTTM'));
    $('#payablesTurnover').text(getValue(statistics, 'payablesTurnoverTTM'));
    $('#inventoryTurnover').text(getValue(statistics, 'inventoryTurnoverTTM'));

    // Capital Expenditure
    $('#capexToOperatingCashFlow').text(getValue(statistics, 'capexToOperatingCashFlowTTM'));
    $('#capexToRevenue').text(getValue(statistics, 'capexToRevenueTTM'));
    $('#capexToDepreciation').text(getValue(statistics, 'capexToDepreciationTTM'));
    $('#capexPerShare').text(getValue(statistics, 'capexPerShareTTM'));

    // Dividends
    $('#dividendPerShare').text(getValue(statistics, 'dividendPerShareTTM'));
    $('#dividendYield').text(getValue(statistics, 'dividendYieldPercentageTTM') + '%');
    $('#payoutRatio').text((getValue(statistics, 'payoutRatioTTM') * 100).toFixed(2) + '%');

    // Other Metrics
    $('#grahamNumber').text(getValue(statistics, 'grahamNumberTTM'));
    $('#grahamNetNet').text(getValue(statistics, 'grahamNetNetTTM'));
    $('#averageReceivables').text(getValue(statistics, 'averageReceivablesTTM'));
    $('#averagePayables').text(getValue(statistics, 'averagePayablesTTM'));
    $('#averageInventory').text(getValue(statistics, 'averageInventoryTTM'));
    $('#daysSalesOutstandingTTM').text(getValue(statistics, 'daysSalesOutstandingTTM'));
    $('#daysPayablesOutstandingTTM').text(getValue(statistics, 'daysPayablesOutstandingTTM'));
    $('#daysOfInventoryOnHandTTM').text(getValue(statistics, 'daysOfInventoryOnHandTTM'));
    $('#receivablesTurnoverTTM').text(getValue(statistics, 'receivablesTurnoverTTM'));
    $('#payablesTurnoverTTM').text(getValue(statistics, 'payablesTurnoverTTM'));
    $('#inventoryTurnoverTTM').text(getValue(statistics, 'inventoryTurnoverTTM'));
    $('#roeTTM').text(getValue(statistics, 'roeTTM'));
    $('#capexPerShareTTM').text(getValue(statistics, 'capexPerShareTTM'));
    $('#dividendPerShareTTM').text(getValue(statistics, 'dividendPerShareTTM'));
}

function clearStatisticsDisplay() {
    $('#statisticsDataContainer .data-value').text('-');
}

function showMessageBox(message) {
    console.log(message);
    alert(message);
}