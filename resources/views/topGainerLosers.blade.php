 @extends('layouts.dashboardLayout')

    @section('title', 'liveChart')

    @section('content')
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
                <div id="marketMoversLoader" class="loader-container" style="display: none;">
                    <div class="loader"></div>
                    <p>Loading market data...</p>
                </div>
				<div class="">
                    <div class="data-card">
                        <div class="card-header">
                            <div class="card-title">Market Movers</div>
                            <div class="market-movers-controls">
                                <!--<div class="exchange-switcher">-->
                                <!--    <button class="exchange-btn active" data-exchange="NSE">NSE</button>-->
                                <!--    <button class="exchange-btn" data-exchange="BSE">BSE</button>-->
                                <!--</div>-->
                                <!-- <div class="movement-switcher">
                                    <button class="movement-btn active" data-type="gainers">Gainers</button>
                                    <button class="movement-btn" data-type="losers">Losers</button>
                                </div> -->
                            </div>
                        </div>
                        <table class="data-table">
                            <thead id="marketMoversTableHead"></thead>
                            <tbody id="marketMoversTableBody"></tbody>
                        </table>
                    </div>
                    
                    <div class="chart-container">
                        <canvas id="marketMoversChart"></canvas>
                    </div>
                </div>
			</main>
		</div>

	<style>
	@media (max-width: 768px) {
	        .res_change_row {

        display: flex !important;
        flex-wrap: wrap;
    }
    .res_sym{
            width: 100%;
    text-align: left;
            justify-content: flex-start !important;
                    color: #4ade80;
    }
	}
	</style>
    @endsection