 @extends('layouts.dashboardLayout')

    @section('title', 'liveChart')

    @section('content')
<style>
    .select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 13px !important;
}
</style>
		<script>
        document.addEventListener('DOMContentLoaded', function () {
            if (localStorage.getItem('showAlert') === 'true') {
                Swal.fire({
                    title: 'Login Successful!',
                    text: 'Welcome to the live chart.',
                    icon: 'success',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#007bff',
                }).then(() => {
                    localStorage.removeItem('showAlert'); // Remove the flag after showing the alert
                });
            }
        });
    </script>
		<script>
			document.addEventListener('DOMContentLoaded', () => {
			  // Hamburger menu toggle
			  const hamburger = document.getElementById('hamburger-menu');
			  const navDropdown = document.getElementById('nav-dropdown');
			
			  hamburger.addEventListener('click', () => {
			    navDropdown.classList.toggle('active');
			  });
			
			  // Close dropdown when clicking outside
			  document.addEventListener('click', (event) => {
			    if (!navDropdown.contains(event.target) && !hamburger.contains(event.target)) {
			      navDropdown.classList.remove('active');
			    }
			  });
			
			  // Tab functionality
			  const tabButtons = document.querySelectorAll('.tab-button');
			  const tabContents = document.querySelectorAll('.tab-content');
			
			  tabButtons.forEach(button => {
			    button.addEventListener('click', () => {
			      const targetTab = button.dataset.tab;
			
			      // Remove active class from all buttons and contents
			      tabButtons.forEach(btn => btn.classList.remove('active'));
			      tabContents.forEach(content => content.classList.remove('active'));
			
			      // Add active class to the clicked button and target content
			      button.classList.add('active');
			      document.getElementById(targetTab).classList.add('active');
			    });
			  });
			
			  // Activate the first tab by default
			  if (tabButtons.length > 0) {
			    tabButtons[0].click();
			  }
			});
		</script>
	<body class="dark-theme">
		<div class="app-container">

			<main class="main-content">
				<nav class="tab-nav">
					<button class="tab-button active" data-tab="overview-tab">Overview</button>
					<button class="tab-button" data-tab="chart-tab">Fundamental Analysis</button>
					<button class="tab-button" data-tab="technical-analysis-tab">Technical Analysis</button>
					<button class="tab-button" data-tab="key-metrics-tab">Key Metrics</button>
					<!--<button class="tab-button" data-tab="share-holding-tab">Share Holding</button>-->
					<!--<button class="tab-button" data-tab="quarterly-results-tab">Quarterly Results</button>-->
					<!--<button class="tab-button" data-tab="pnl-tab">P&L</button>-->
					<button class="tab-button" data-tab="cash-flow-tab">Cash Flow</button>
					<button class="tab-button" data-tab="corporate-actions-tab">Corporate Actions</button>
					<button class="tab-button" data-tab="company-details-tab">Company Details</button>
				</nav>
				<div style="padding: 15px">
				    <div id="overview-tab" class="tab-content active">
					<section class="chart-section">
						<div class="chart-container">
							<div class="control-group" style="margin-bottom: 1.5rem;">
								<select id="stockSelector"></select>
								<div class="timeframe-selector" id="timeframeSelector">
									<button data-range="1d">1D</button>
									<button data-range="1w">1W</button>
									<button data-range="1m">1M</button>
									<button data-range="3m">3M</button>
									<button data-range="1y">1Y</button>
									<button data-range="3y">3Y</button>
									<button data-range="5y">5Y</button>
									<button data-range="max">MAX</button>
								</div>
								<select id="exchangeSwitch" class="form-select">
                                    <option value="NSE">NSE</option>
                                    <option value="BSE">BSE</option>
                                </select>
							</div>
							<div class="chart-header">
								<div class="chart-title">
									<h2 id="chartTitle">Price Chart</h2>
								</div>
								<div class="chart-actions">
									<button>
									<i class="fas fa-expand"></i>
									</button>
								</div>
							</div>
							<canvas id="stockChart"></canvas>
						</div>
					</section>
					<div class="data-grid">
						<div class="data-card">
							<div class="card-header">
								<div class="card-title">Current Market Data</div>
							</div>
							<div class="data-row">
								<span class="data-label">Open:</span>
								<span class="data-value" id="latestOpen">N/A</span>
							</div>
							<div class="data-row">
								<span class="data-label">High:</span>
								<span class="data-value" id="latestHigh">N/A</span>
							</div>
							<div class="data-row">
								<span class="data-label">Low:</span>
								<span class="data-value" id="latestLow">N/A</span>
							</div>
							<div class="data-row">
								<span class="data-label">Close:</span>
								<span class="data-value" id="latestClose">N/A</span>
							</div>
							<div class="data-row">
								<span class="data-label">Percent Change:</span>
								<span class="data-value" id="percentChange">N/A</span>
							</div>
							<div class="data-row">
								<span class="data-label">Change:</span>
								<span class="data-value" id="priceChange">N/A</span>
							</div>
							<div class="data-row">
								<span class="data-label">Volume:</span>
								<span class="data-value" id="latestVolume">N/A</span>
							</div>
						</div>
						<div class="data-card">
							<div class="card-header">
								<div class="card-title">Current Market Status</div>
							</div>
							<div class="data-row">
								<span class="data-label">Market Status:</span>
								<span class="data-value" id="marketStatus">N/A</span>
							</div>
							<div class="data-row">
								<span class="data-label">52-Week Low:</span>
								<span class="data-value" id="fiftyTwoWeekLow">N/A</span>
							</div>
							<div class="data-row">
								<span class="data-label">52-Week High:</span>
								<span class="data-value" id="fiftyTwoWeekHigh">N/A</span>
							</div>
							<div class="data-row">
								<span class="data-label">52-Week Range:</span>
								<span class="data-value" id="fiftyTwoWeekRange">N/A</span>
							</div>
							<div class="data-row">
								<span class="data-label">Extended Price:</span>
								<span class="data-value" id="extendedPrice">N/A</span>
							</div>
							<div class="data-row">
								<span class="data-label">Extended Change:</span>
								<span class="data-value" id="extendedChange">N/A</span>
							</div>
							<div class="data-row">
								<span class="data-label">Extended Percent Change:</span>
								<span class="data-value" id="extendedPercentChange">N/A</span>
							</div>
						</div>
					</div>
					<div class="data-grid" style="margin-bottom: 2rem;">
						<div class="data-card">
							<div class="card-header">
								<div class="card-title">Market Sentiment</div>
								<div class="card-actions">
									<button>
									<i class="fas fa-ellipsis-h"></i>
									</button>
								</div>
							</div>
							<div class="sentiment-meter">
								<div class="sentiment-progress" style="width: 65%"></div>
							</div>
							<div class="sentiment-data">
								<div class="santi-data-row">
									<span class="data-label">1D:</span>
									<span class="data-value" id="sentiment1d"></span>
								</div>
								<div class="santi-data-row">
									<span class="data-label">1W:</span>
									<span class="data-value" id="sentiment1w"></span>
								</div>
								<div class="santi-data-row">
									<span class="data-label">1M:</span>
									<span class="data-value" id="sentiment1m"></span>
								</div>
								<div class="santi-data-row">
									<span class="data-label">3M:</span>
									<span class="data-value" id="sentiment3m"></span>
								</div>
							</div>
						</div>
					</div>
					<div class="data-card" style="margin-bottom: 2rem;">
						<div class="card-header">
							<div class="card-title">Historical Data (Past 24 Days)</div>
							<div class="card-actions">
								<button>
								<i class="fas fa-ellipsis-h"></i>
								</button>
							</div>
						</div>
						<div class="historical-grid" id="pastCardContainer"></div>
					</div>
					<div class="data-grid">
						<div class="data-card">
							<div class="card-header">
								<div class="card-title">Returns Analysis</div>
								<div class="card-actions">
									<button>
									<i class="fas fa-ellipsis-h"></i>
									</button>
								</div>
							</div>
							<div class="data-row">
								<span class="data-label">Daily:</span>
								<span class="data-value" id="descDaily"></span>
							</div>
							<div class="data-row">
								<span class="data-label">Weekly:</span>
								<span class="data-value" id="descWeekly"></span>
							</div>
							<div class="data-row">
								<span class="data-label">Monthly:</span>
								<span class="data-value" id="descMonthly"></span>
							</div>
							<div class="data-row">
								<span class="data-label">Yearly:</span>
								<span class="data-value" id="descYearly"></span>
							</div>
						</div>
					</div>
				</div>
				<div id="chart-tab" class="tab-content">
					<div class="chart-section-fl">
						<div class="graph-container">
							<h2>Combined Chart (Sales, Gross Profit, Net Income)</h2>
							<canvas id="combinedChart"></canvas>
						</div>
						<div class="graph-container">
							<h2>Operating Income and EBITDA</h2>
							<canvas id="operatingIncomeChart"></canvas>
						</div>
					</div>
					<div class="table-container">
						<h2>Income Statement Table</h2>
						<div class="table-wrapper">
							<!-- Time Column -->
							<div class="metrics-table">
								<table id="incomeStatementTable" border="1" cellpadding="10" cellspacing="0">
									<thead id="incomeStatementTableHead">
										<!-- Dynamic headers will go here -->
									</thead>
									<tbody id="incomeStatementTableBody">
										<!-- Rows will be dynamically added here -->
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div>
						<h2>Balance Sheet Analysis</h2>
						<div class="balance-sheet-section">
							<div class="balance-chart-section">
								<canvas id="balanceSheetChart"></canvas>
							</div>
							<div class="table-container">
								<div class="table-wrapper">
									<table id="balanceSheetTable" border="1" cellpadding="10" cellspacing="0">
										<thead id="balanceSheetHeaderRow">
											<!-- Dates will be dynamically added here as table headers -->
										</thead>
										<tbody id="balanceSheetTableBody">
											<!-- Financial data rows will be dynamically added here -->
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<div class="data-card">
						<div class="card-header">
							<div class="card-title">Earnings Data</div>
						</div>
						<table class="data-table">
							<thead id="earningsTableHead"></thead>
							<tbody id="earningsTableBody"></tbody>
						</table>
					</div>
					
				</div>
				<div id="technical-analysis-tab" class="tab-content">
					<div class="data-card">
						<div class="card-header">
							<div class="card-title">Moving Averages</div>
							<div class="card-actions">
								<button>
								<i class="fas fa-ellipsis-h"></i>
								</button>
							</div>
						</div>
						<div class="data-row">
							<span class="data-label">20-Day:</span>
							<span class="data-value" id="ma20Status"></span>
						</div>
						<div class="data-row">
							<span class="data-label">50-Day:</span>
							<span class="data-value" id="ma50Status"></span>
						</div>
						<div class="data-row">
							<span class="data-label">100-Day:</span>
							<span class="data-value" id="ma100Status"></span>
						</div>
						<div class="data-row">
							<span class="data-label">200-Day:</span>
							<span class="data-value" id="ma200Status"></span>
						</div>
					</div>
					<div class="momentum-container">
						<div id="momentumSummary" style="font-weight: bold; margin-bottom: 10px;"></div>
						<div id="momentumTable" class="momentum-table"></div>
						<div>
							<h3 id="trendSummary" style="margin-top: 20px;">Trend Oscillators (Buy : 0)(Sell: 0)(Neutral: 0)</h3>
							<table border="1" cellpadding="10" cellspacing="0">
								<thead>
									<tr>
										<th>Name</th>
										<th>Value</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<tr id="trendMACD">
										<td>MACD(12,26)</td>
										<td class="trend-value">-</td>
										<td class="trend-action">-</td>
									</tr>
									<tr id="trendADX">
										<td>ADX(14)</td>
										<td class="trend-value">-</td>
										<td class="trend-action">-</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div id="marketIndicators">
						<h3> Market Analysis</h3>
						<table>
							<tr>
								<th>Indicator</th>
								<th>Value</th>
							</tr>
							<tr>
								<td>Bollinger Bands (20)</td>
								<td id="bollingerValue"></td>
							</tr>
							<tr>
								<td>ATR (14)</td>
								<td id="atrValue"></td>
							</tr>
							<tr>
								<td>On-Balance Volume (OBV)</td>
								<td id="obvValue"></td>
							</tr>
							<tr>
								<td>Latest Candle</td>
								<td id="candleValue"></td>
							</tr>
						</table>
					</div>
					<div id="marketIndicators">
						<h3>Pivot Points</h3>
						<div id="pivotTableContainer"></div>
					</div>
				</div>
				<div id="key-metrics-tab" class="tab-content">
    <div id="statisticsDataContainer" style="margin-top: 0;">
        <h2 class="section-title">Stock Statistics</h2>
        
        <!-- Valuation Metrics -->
        <div class="data-card" style="margin-bottom: 1.5rem;">
            <div class="card-header">
                <div class="card-title">
                    <i class="fas fa-chart-line icon-blue"></i> Valuation Metrics
                </div>
            </div>
            <div class="data-grid">
                <div class="data-row">
                    <span class="data-label"><i class="fas fa-chart-line icon-blue"></i> Market Capitalization:</span>
                    <span class="data-value" id="marketCapitalization">-</span>
                </div>
                <div class="data-row">
                    <span class="data-label"><i class="fas fa-building icon-green"></i> Enterprise Value:</span>
                    <span class="data-value" id="enterpriseValue">-</span>
                </div>
                <div class="data-row">
                    <span class="data-label"><i class="fas fa-percentage icon-orange"></i> Trailing P/E:</span>
                    <span class="data-value" id="trailingPE">-</span>
                </div>
                <div class="data-row">
                    <span class="data-label"><i class="fas fa-chart-bar icon-blue"></i> Price to Sales (TTM):</span>
                    <span class="data-value" id="priceToSalesTTM">-</span>
                </div>
                <div class="data-row">
                    <span class="data-label"><i class="fas fa-book icon-green"></i> Price to Book:</span>
                    <span class="data-value" id="priceToBookMRQ">-</span>
                </div>
                <div class="data-row">
                    <span class="data-label"><i class="fas fa-receipt icon-purple"></i> Enterprise to Revenue:</span>
                    <span class="data-value" id="enterpriseToRevenue">-</span>
                </div>
                <div class="data-row">
                    <span class="data-label"><i class="fas fa-chart-pie icon-orange"></i> Enterprise to EBITDA:</span>
                    <span class="data-value" id="enterpriseToEBITDA">-</span>
                </div>
                <div class="data-row">
                    <span class="data-label"><i class="fas fa-money-bill-wave icon-blue"></i> Price to Operating Cash Flow:</span>
                    <span class="data-value" id="priceToOperatingCashFlow">-</span>
                </div>
                <div class="data-row">
                    <span class="data-label"><i class="fas fa-money-bill-wave-alt icon-green"></i> Price to Free Cash Flow:</span>
                    <span class="data-value" id="priceToFreeCashFlow">-</span>
                </div>
                <div class="data-row">
                    <span class="data-label"><i class="fas fa-coins icon-yellow"></i> Earnings Yield:</span>
                    <span class="data-value" id="earningsYield">-</span>
                </div>
                <div class="data-row">
                    <span class="data-label"><i class="fas fa-coins icon-yellow"></i> Free Cash Flow Yield:</span>
                    <span class="data-value" id="freeCashFlowYield">-</span>
                </div>
            </div>
        </div>
        
        <!-- Financial Health -->
        <div class="data-card" style="margin-bottom: 1.5rem;">
            <div class="card-header">
                <div class="card-title">
                    <i class="fas fa-heartbeat icon-red"></i> Financial Health
                </div>
            </div>
            <div class="data-grid">
                <div class="data-row">
                    <span class="data-label"><i class="fas fa-balance-scale icon-blue"></i> Current Ratio:</span>
                    <span class="data-value" id="currentRatio">-</span>
                </div>
                <div class="data-row">
                    <span class="data-label"><i class="fas fa-hand-holding-usd icon-orange"></i> Debt to Equity:</span>
                    <span class="data-value" id="debtToEquity">-</span>
                </div>
                <div class="data-row">
                    <span class="data-label"><i class="fas fa-landmark icon-green"></i> Debt to Assets:</span>
                    <span class="data-value" id="debtToAssets">-</span>
                </div>
                <div class="data-row">
                    <span class="data-label"><i class="fas fa-file-invoice-dollar icon-purple"></i> Net Debt to EBITDA:</span>
                    <span class="data-value" id="netDebtToEBITDA">-</span>
                </div>
                <div class="data-row">
                    <span class="data-label"><i class="fas fa-percentage icon-red"></i> Interest Coverage:</span>
                    <span class="data-value" id="interestCoverage">-</span>
                </div>
            </div>
        </div>
        
        <!-- Profitability -->
        <div class="data-card" style="margin-bottom: 1.5rem;">
            <div class="card-header">
                <div class="card-title">
                    <i class="fas fa-chart-line icon-green"></i> Profitability
                </div>
            </div>
            <div class="data-grid">
                <div class="data-row">
                    <span class="data-label"><i class="fas fa-percentage icon-orange"></i> Profit Margin:</span>
                    <span class="data-value" id="profitMargin">-</span>
                </div>
                <div class="data-row">
                    <span class="data-label"><i class="fas fa-chart-area icon-purple"></i> Return on Equity:</span>
                    <span class="data-value" id="returnOnEquity">-</span>
                </div>
                <div class="data-row">
                    <span class="data-label"><i class="fas fa-chart-bar icon-blue"></i> Return on Tangible Assets:</span>
                    <span class="data-value" id="returnOnTangibleAssets">-</span>
                </div>
                <div class="data-row">
                    <span class="data-label"><i class="fas fa-project-diagram icon-green"></i> Return on Invested Capital:</span>
                    <span class="data-value" id="returnOnInvestedCapital">-</span>
                </div>
                <div class="data-row">
                    <span class="data-label"><i class="fas fa-star icon-yellow"></i> Income Quality:</span>
                    <span class="data-value" id="incomeQuality">-</span>
                </div>
            </div>
        </div>
        
        <!-- Income Statement -->
        <div class="data-card" style="margin-bottom: 1.5rem;">
            <div class="card-header">
                <div class="card-title">
                    <i class="fas fa-file-invoice-dollar icon-green"></i> Income Statement
                </div>
            </div>
            <div class="data-grid">
                <div class="data-row">
                    <span class="data-label"><i class="fas fa-chart-bar icon-blue"></i> Revenue per Share:</span>
                    <span class="data-value" id="revenuePerShare">-</span>
                </div>
                <div class="data-row">
                    <span class="data-label"><i class="fas fa-percentage icon-orange"></i> Net Income per Share:</span>
                    <span class="data-value" id="netIncomePerShare">-</span>
                </div>
                <div class="data-row">
                    <span class="data-label"><i class="fas fa-exchange-alt icon-purple"></i> Operating Cash Flow per Share:</span>
                    <span class="data-value" id="operatingCashFlowPerShare">-</span>
                </div>
                <div class="data-row">
                    <span class="data-label"><i class="fas fa-dollar-sign icon-yellow"></i> Free Cash Flow per Share:</span>
                    <span class="data-value" id="freeCashFlowPerShare">-</span>
                </div>
                <div class="data-row">
                    <span class="data-label"><i class="fas fa-flask icon-blue"></i> R&D to Revenue:</span>
                    <span class="data-value" id="researchAndDevelopementToRevenue">-</span>
                </div>
                <div class="data-row">
                    <span class="data-label"><i class="fas fa-user-tie icon-green"></i> Stock Compensation to Revenue:</span>
                    <span class="data-value" id="stockBasedCompensationToRevenue">-</span>
                </div>
            </div>
        </div>
        
        <!-- Balance Sheet -->
        <div class="data-card" style="margin-bottom: 1.5rem;">
            <div class="card-header">
                <div class="card-title">
                    <i class="fas fa-balance-scale-left icon-blue"></i> Balance Sheet
                </div>
            </div>
            <div class="data-grid">
                <div class="data-row">
                    <span class="data-label"><i class="fas fa-money-bill-alt icon-orange"></i> Cash per Share:</span>
                    <span class="data-value" id="cashPerShare">-</span>
                </div>
                <div class="data-row">
                    <span class="data-label"><i class="fas fa-book-open icon-green"></i> Book Value per Share:</span>
                    <span class="data-value" id="bookValuePerShare">-</span>
                </div>
                <div class="data-row">
                    <span class="data-label"><i class="fas fa-book icon-blue"></i> Tangible Book Value per Share:</span>
                    <span class="data-value" id="tangibleBookValuePerShare">-</span>
                </div>
                <div class="data-row">
                    <span class="data-label"><i class="fas fa-file-invoice-dollar icon-red"></i> Interest Debt per Share:</span>
                    <span class="data-value" id="interestDebtPerShare">-</span>
                </div>
                <div class="data-row">
                    <span class="data-label"><i class="fas fa-percentage icon-orange"></i> Debt to Market Cap:</span>
                    <span class="data-value" id="debtToMarketCap">-</span>
                </div>
                <div class="data-row">
                    <span class="data-label"><i class="fas fa-business-time icon-green"></i> Working Capital:</span>
                    <span class="data-value" id="workingCapital">-</span>
                </div>
                <div class="data-row">
                    <span class="data-label"><i class="fas fa-cubes icon-blue"></i> Tangible Asset Value:</span>
                    <span class="data-value" id="tangibleAssetValue">-</span>
                </div>
                <div class="data-row">
                    <span class="data-label"><i class="fas fa-cube icon-purple"></i> Net Current Asset Value:</span>
                    <span class="data-value" id="netCurrentAssetValue">-</span>
                </div>
                <div class="data-row">
                    <span class="data-label"><i class="fas fa-project-diagram icon-green"></i> Invested Capital:</span>
                    <span class="data-value" id="investedCapital">-</span>
                </div>
            </div>
        </div>
        
        <!-- Efficiency Metrics -->
        <div class="data-card" style="margin-bottom: 1.5rem;">
            <div class="card-header">
                <div class="card-title">
                    <i class="fas fa-tachometer-alt icon-orange"></i> Efficiency Metrics
                </div>
            </div>
            <div class="data-grid">
                <div class="data-row">
                    <span class="data-label"><i class="fas fa-calendar-day icon-blue"></i> Days Sales Outstanding:</span>
                    <span class="data-value" id="daysSalesOutstanding">-</span>
                </div>
                <div class="data-row">
                    <span class="data-label"><i class="fas fa-calendar-day icon-green"></i> Days Payables Outstanding:</span>
                    <span class="data-value" id="daysPayablesOutstanding">-</span>
                </div>
                <div class="data-row">
                    <span class="data-label"><i class="fas fa-calendar-day icon-red"></i> Days of Inventory on Hand:</span>
                    <span class="data-value" id="daysOfInventoryOnHand">-</span>
                </div>
                <div class="data-row">
                    <span class="data-label"><i class="fas fa-sync-alt icon-purple"></i> Receivables Turnover:</span>
                    <span class="data-value" id="receivablesTurnover">-</span>
                </div>
                <div class="data-row">
                    <span class="data-label"><i class="fas fa-sync-alt icon-green"></i> Payables Turnover:</span>
                    <span class="data-value" id="payablesTurnover">-</span>
                </div>
                <div class="data-row">
                    <span class="data-label"><i class="fas fa-sync-alt icon-blue"></i> Inventory Turnover:</span>
                    <span class="data-value" id="inventoryTurnover">-</span>
                </div>
            </div>
        </div>
        
        <!-- Capital Expenditure -->
        <div class="data-card" style="margin-bottom: 1.5rem;">
            <div class="card-header">
                <div class="card-title">
                    <i class="fas fa-hard-hat icon-yellow"></i> Capital Expenditure
                </div>
            </div>
            <div class="data-grid">
                <div class="data-row">
                    <span class="data-label"><i class="fas fa-exchange-alt icon-blue"></i> Capex to Operating Cash Flow:</span>
                    <span class="data-value" id="capexToOperatingCashFlow">-</span>
                </div>
                <div class="data-row">
                    <span class="data-label"><i class="fas fa-chart-line icon-green"></i> Capex to Revenue:</span>
                    <span class="data-value" id="capexToRevenue">-</span>
                </div>
                <div class="data-row">
                    <span class="data-label"><i class="fas fa-chart-bar icon-purple"></i> Capex to Depreciation:</span>
                    <span class="data-value" id="capexToDepreciation">-</span>
                </div>
                <div class="data-row">
                    <span class="data-label"><i class="fas fa-coins icon-yellow"></i> Capex per Share:</span>
                    <span class="data-value" id="capexPerShare">-</span>
                </div>
            </div>
        </div>
        
        <!-- Dividends -->
        <div class="data-card">
            <div class="card-header">
                <div class="card-title">
                    <i class="fas fa-gift icon-purple"></i> Dividends
                </div>
            </div>
            <div class="data-grid">
                <div class="data-row">
                    <span class="data-label"><i class="fas fa-hand-holding-usd icon-orange"></i> Dividend per Share:</span>
                    <span class="data-value" id="dividendPerShare">-</span>
                </div>
                <div class="data-row">
                    <span class="data-label"><i class="fas fa-percentage icon-purple"></i> Dividend Yield:</span>
                    <span class="data-value" id="dividendYield">-</span>
                </div>
                <div class="data-row">
                    <span class="data-label"><i class="fas fa-percentage icon-green"></i> Payout Ratio:</span>
                    <span class="data-value" id="payoutRatio">-</span>
                </div>
            </div>
        </div>
        
        <!-- Other Metrics -->
        <div class="data-card" style="margin-top: 1.5rem;">
            <div class="card-header">
                <div class="card-title">
                    <i class="fas fa-cubes icon-blue"></i> Other Metrics
                </div>
            </div>
            <div class="data-grid">
                <div class="data-row">
                    <span class="data-label"><i class="fas fa-calculator icon-green"></i> Graham Number:</span>
                    <span class="data-value" id="grahamNumber">-</span>
                </div>
                <div class="data-row">
                    <span class="data-label"><i class="fas fa-calculator icon-blue"></i> Graham Net Net:</span>
                    <span class="data-value" id="grahamNetNet">-</span>
                </div>
            </div>
        </div>
    </div>
</div>
		<div id="share-holding-tab" class="tab-content">
					<div class="data-card">
						<div class="card-header">
							<div class="card-title">Share Holding Data</div>
						</div>
						<h3 class="mt-4">🏛 Institutional Ownership Breakdown</h3>
<div id="institutionalOwnershipLoader" style="display:none;">Loading...</div>
<table class="table table-bordered mt-2">
    <thead>
        <tr>
            <th>Date</th>
            <th>Investor</th>
            <th>Ownership %</th>
            <th>Shares Held</th>
            <th>Market Value</th>
            <th>Change in Ownership</th>
        </tr>
    </thead>
    <tbody id="institutionalOwnershipBody">
        <!-- Populated dynamically -->
    </tbody>
</table>

					</div>
				</div>
				<div id="quarterly-results-tab" class="tab-content">
					<div class="data-card">
						<div class="card-header">
							<div class="card-title">Quarterly Results</div>
						</div>
						<p>Quarterly results data will be displayed here.</p>
					</div>
				</div>
				<div id="pnl-tab" class="tab-content">
					<div class="data-card">
						<div class="card-header">
							<div class="card-title">Profit and Loss (P&L)</div>
						</div>
						<p>Profit and Loss data will be displayed here.</p>
					</div>
				</div>
				<div id="cash-flow-tab" class="tab-content">
					<div class="chart-section">
						<h2>Cash Flow Chart</h2>
						<canvas id="cashFlowChart"></canvas>
					</div>
					<div class="chart-section">
						<h2>Free Cash Flow vs Net Income</h2>
						<canvas id="freeCashFlowChart"></canvas>
					</div>
					<div class="table-container">
						<h2>Cash Flow Table</h2>
						<table id="cashFlowTable" border="1" cellpadding="10" cellspacing="0">
							<thead id="cashFlowTableHead">
								<!-- Dynamic headers will go here -->
							</thead>
							<tbody id="cashFlowTableBody">
								<!-- Rows will be dynamically added here -->
							</tbody>
						</table>
					</div>
				</div>
				<div id="corporate-actions-tab" class="tab-content">
					<div id="fundamentalDataContainer" style="margin-top: 0;">
					<h3>Dividend History</h3>
                        <table id="fundamentalDataTable" border="1" cellpadding="10" cellspacing="0">
                          <thead>
                            <tr>
                              <th>Date</th>
                              <th>Dividend</th>
                              <th>Declaration Date</th>
                              <th>Payment Date</th>
                            </tr>
                          </thead>
                          <tbody></tbody>
                        </table>
					</div>
					<div id="fetchFundamentalSplitssData" style="margin-top: 20px;">
						<h3>Stock Splits</h3>
                            <table id="splitsDataTable" border="1" cellpadding="10" cellspacing="0">
                              <thead>
                                <tr>
                                  <th>Date</th>
                                  <th>Ratio</th>
                                  <th>Label</th>
                                </tr>
                              </thead>
                              <tbody></tbody>
                            </table>
					</div>
				</div>
				<div id="company-details-tab" class="tab-content">
					<div id="companyProfileContainer" class="profile-container">
						<!-- Company profile, logo, and executives will be dynamically added here -->
					</div>
				</div>
			</main>
		</div>
		<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
    .text-success { color: #28a745 !important; }
.text-danger { color: #dc3545 !important; }
.text-muted { color: #6c757d !important; }

</style>
	</body>
    @endsection