@extends('layouts.dashboardLayout')
@section('title', 'liveChart')
@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<style>
	/* General Body and Theme */
	* {
	padding: 0;
	margin: 0;
	box-sizing: border-box;
	}
	a {
	text-decoration: none;
	color: #ffffff;
	}
	/* Card Specific Styles */
	.card {
	background-color: #fff;
	border: none;
	border-radius: 8px;
	    box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
	    color: #100;
	}
	.card-header-with-link {
	display: flex;
	justify-content: space-between;
	align-items: center;
	/*margin-bottom: 25px; */
	}
	.card-header-with-link h5 {
	margin-bottom: 0;
	border-bottom: 2px solid rgb(74 222 128); /* Added back for consistency */
	width: fit-content;
	padding-bottom: 4px;
	}
	.watchlist_sect h5{
	    	margin-bottom: 20px;
	border-bottom: 2px solid rgb(74 222 128); /* Added back for consistency */
	width: fit-content;
	padding-bottom: 4px;
	}
	.view-all-link {
	font-size: 13px;
	color: #007bff; /* Custom blue for links */
	text-decoration: none;
	display: flex;
	align-items: center;
	}
	.view-all-link i {
	margin-left: 5px;
	}
	/* Highlight Colors */
	.highlight-green {
	color: #4ade80 !important;
	}
	.highlight-red {
	color: #dc3545 !important;
	}
	.custom-primary {
	color: #4ade80; /* Custom blue color */
	}
	.custom-success {
	color: #4ade80; /* Custom green color */
	}
	.custom-warning {
	color: #4ade80; /* Custom yellow color */
	}
	.custom-danger {
	color: #dc3545; /* Custom red color */
	}
	.custom-info {
	color: #4ade80; /* Custom light blue color */
	}
	/* Market Header (if used) */
	.market-header {
	background-color: #1e1e1e;
	padding: 10px;
	}
	.market-header .col {
	display: flex;
	align-items: center;
	justify-content: space-between;
	border-right: 1px solid #cccccc33;
	}
	.market-header div {
	margin-bottom: 8px;
	text-align: left;
	}
	.market-header h6 {
	font-size: 14px;
	font-weight: bold;
	color: #ccc;
	margin: 0;
	margin-bottom: 5px;
	}
	.market-header small {
	font-size: 12px;
	color: #888;
	display: block;
	}
	.market-header p {
	font-size: 13px;
	font-weight: bold;
	margin: 0;
	color: #ffffff;
	}
	/* Watchlist and Explore Section Buttons */
	.watchlist_sect button {
	color: #fff;
	border-bottom: 1px solid;
	border-radius: 0;
	padding: 0;
	background: none; /* Ensure no default button background */
	border: none; /* Ensure no default button border */
	width: 32%;
	border: 1px dashed #ccc;
		border-radius: 5px;
	}
	.watchlist_sect button a {
	display: flex;
	align-items: center;
	padding: 8px 12px; /* Add some padding for better click area */
	transition: background-color 0.2s ease-in-out;
	color: #000;
	text-align: center;
	}
	.watchlist_sect button a i{
	    color: #4ade80 ;
	}
	.watchlist_sect button a:hover {
	background-color: rgba(12, 109, 253, 0.1);
	}
	.watchlist_sect button svg, .watchlist_sect button i {
	margin-right: 8px;
	font-size: 16px;
	}
	.watchlist-item {
	display: flex;
	justify-content: space-between;
	align-items: center;
	padding: 8px 0;
	border-bottom: 1px solid #2a2a2a;
	}
	.watchlist-item:last-child {
	border-bottom: none;
	}
	.watchlist-item .stock-name {
	font-weight: bold;
	color: #000;
	}
	.watchlist-item .stock-price {
	font-size: 14px;
	color: #2e2e2e;
	}
	.watchlist-item .change-percentage {
	font-size: 13px;
	font-weight: bold;
	}
	/* Basket Item Styling */
	.basket-item {
	margin-bottom: 15px;
	padding: 15px;
	border: 1px solid #333;
	border-radius: 8px;
	background-color: rgb(0 85 80);
	}
	.basket-item h6 {
	margin-bottom: 0;
	color: #fff;
	font-size: 16px;
	display: flex;
	align-items: center;
	gap: 10px;
	}
	.basket-item h6 i {
	margin-right: 8px;
	}
	.basket-stock {
	    border-top: 1px dashed #fff;
    padding-top: 10px;
    margin-top: 10px;
	}
	.basket-stock:first-of-type {
	border-top: none;
	padding-top: 0;
	margin-top: 0;
	}
	.basket-stock p {
	font-size: 13px;
	margin-bottom: 2px;
	color: #ccc;
	}
	.basket-stock .value {
	font-weight: bold;
	}
	.basket-stock .value.green {
	color: #00ff00; /* Green for positive values */
	}
	.basket-stock .value.red {
	color: #ff0000; /* Red for negative values or stop loss */
	}
	/* Strategy and Prediction Boxes */
	.strategy-box, .prediction-box {
	background-color: #fff;
	border-radius: 8px;
	padding: 20px;
	margin-top: 20px;
	    box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
	}
	.strategy-box h5, .prediction-box h5 {
	border-bottom: 2px solid rgb(74 222 128);
	width: fit-content;
	padding-bottom: 4px;
	margin-bottom: 15px;
	}
	.strategy-box p, .prediction-box p {
	font-size: 14px;
	color: #343434;
	line-height: 1.6;
	}
	.strategy-box img, .prediction-box img {
	width: 100%;
	height: auto;
	border-radius: 5px;
	margin-top: 15px;
	margin-bottom: 15px;
	border: 1px solid #ccc;
	}
	/* Modal (Ask the Analyst Popup) */
	#centerPopup {
	position: fixed;
	top: 50%;
	left: 50%;
	transform: translate(-50%, -50%) scale(0.8);
	width: 400px;
	background: #fff;
	box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
	border-radius: 8px;
	padding: 20px;
	z-index: 10001;
	opacity: 0;
	visibility: hidden;
	transition: all 0.3s ease;
	}
	#centerPopup{
	color: #000 !important;
	}
	#centerPopup.open {
	transform: translate(-50%, -50%) scale(1);
	opacity: 1;
	visibility: visible;
	}
	.popup-header {
	display: flex;
	justify-content: space-between;
	align-items: center;
	border-bottom: 1px solid #ccc;
	padding-bottom: 10px;
	}
	.popup-header h4 {
	margin: 0;
	}
	#closePopup {
	background: none;
	border: none;
	font-size: 24px;
	cursor: pointer;
	color: #000;
	}
	.popup-body {
	margin-top: 20px;
	}
	#overlay {
	position: fixed;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	background: rgba(0, 0, 0, 0.4);
	display: none;
	z-index: 10000;
	}
	/* Responsive adjustments */
	@media (max-width: 768px) {
	.d-flex.flex-wrap .btn {
	flex: 1 1 auto; /* Allow buttons to wrap and take full width */
	margin-right: 0 !important;
	margin-bottom: 10px !important;
	}
	.row.my-3 {
	flex-direction: column;
	}
	.col-lg-3, .col-lg-9 {
	width: 100%;
	margin-bottom: 20px;
	}
	.col-md-4 {
	width: 100%;
	margin-bottom: 15px;
	}

	}
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
	$(document).ready(function () {
	   $('#openPopup').click(function () {
	      $('#centerPopup').addClass('open');
	      $('#overlay').fadeIn();
	   });
	
	   $('#closePopup, #overlay').click(function () {
	      $('#centerPopup').removeClass('open');
	      $('#overlay').fadeOut();
	   });
	});
	
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
	
	   // Tab functionality (if applicable, not explicitly used in this snippet, but good to keep if part of larger layout)
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
	<div style="background-color: #ffffff;" class="py-1 px-3">
		<div class="row my-3" style="display: flex;">
			<div class="col-lg-3 d-flex flex-column">
				<div class="card p-3 flex-grow-1">
					<div class="card-header-with-link">
						<h5>My Watchlist</h5>
						<a href="#" class="view-all-link">View All <i class="fas fa-arrow-right"></i></a>
					</div>
					<div class="watchlist-container">
						<!-- Dummy NSE Stocks -->
						<div class="watchlist-item">
							<span class="stock-name">Reliance</span>
							<span class="stock-price">₹2,950.25</span>
							<span class="change-percentage highlight-green">+1.23%</span>
						</div>
						<div class="watchlist-item">
							<span class="stock-name">TCS</span>
							<span class="stock-price">₹4,120.10</span>
							<span class="change-percentage highlight-red">-0.85%</span>
						</div>
						<div class="watchlist-item">
							<span class="stock-name">HDFC Bank</span>
							<span class="stock-price">₹1,560.40</span>
							<span class="change-percentage highlight-green">+0.40%</span>
						</div>
						<div class="watchlist-item">
							<span class="stock-name">Infosys</span>
							<span class="stock-price">₹1,630.90</span>
							<span class="change-percentage highlight-red">-1.50%</span>
						</div>
						<div class="watchlist-item">
							<span class="stock-name">ICICI Bank</span>
							<span class="stock-price">₹1,100.75</span>
							<span class="change-percentage highlight-green">+0.95%</span>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-9 d-flex flex-column">
				<div class="card p-3 flex-grow-1 watchlist_sect">
					<h5>Explore</h5>
					<div class="d-flex flex-wrap">
						<button class="btn me-2 mb-2">
						<a href="/chatbot">
						<i class="fas fa-search custom-warning"></i> Stock Analyzer
						</a>
						</button>
						<button class="btn me-2 mb-2">
						<a href="/TradingDashboard"><i class="fas fa-chart-line custom-info"></i> Daily Analysis</a>
						</button>
						<button class="btn me-2 mb-2">
						<a href="/topGainerLosers"><i class="fas fa-chart-line custom-primary"></i> Market Movers</a>
						</button>
						<button class="btn me-2 mb-2">
						<a href="#">
						<i class="fas fa-sliders-h custom-info"></i> Indicators
						</a>
						</button>
						<!-- Trigger Button -->
						<button class="btn me-2 mb-2" id="openPopup">
						<a><i class="fas fa-question-circle custom-info"></i> Ask The Analyst</a>
						</button>
						<!-- New Buttons with Icons and Links -->
						<button class="btn me-2 mb-2">
						<a href="#">
						<i class="fas fa-wallet custom-success"></i> Free Portfolio Analyze
						</a>
						</button>
						<button class="btn me-2 mb-2">
						<a href="#">
						<i class="fas fa-book-reader custom-primary"></i> Learning
						</a>
						</button>
					</div>
				</div>
			</div>
		</div>
		<div class="row" style="display: flex;">
			<div class="col-lg-6 d-flex flex-column">
				<div class="card p-3 flex-grow-1 prediction-box mb-4">
					<div class="d-flex justify-content-between align-items-center mb-2">
						<h5 class="mb-0">Market Prediction</h5>
						<a href="{{ route('dashboard.all-predictions') }}" class="text-primary small">
						View All <i class="fas fa-arrow-right"></i>
						</a>
					</div>
					@if($prediction)
					@if($prediction->range)
					<h2>{{ $prediction->title }}</h2>
					@endif
					@if($prediction->image_url)
					<!--<img src="{{ asset($prediction->image_url) }}" alt="Market Prediction" class="img-fluid rounded mb-3" style="max-height: 300px; object-fit: cover;">-->
					@else
					<!--<img src="https://placehold.co/600x200/2a2a2a/fff?text=Market+Outlook" alt="Default Image" class="img-fluid rounded mb-3">-->
					@endif
					<p>{{ \Illuminate\Support\Str::limit($prediction->description, 150) }}</p>
					@if($prediction->range)
					<p><strong>Expected range:</strong> {{ $prediction->range }}</p>
					@endif
					@if($prediction->range)
					<p><strong>Support Levels:</strong> {{ $prediction->support_levels }}</p>
					@endif
					@if($prediction->range)
					<p><strong>Resistance Levels:</strong> {{ $prediction->resistance_levels }}</p>
					@endif
					@if($prediction->range)
					<p><strong> Volatility Alert:</strong> {{ $prediction->volatility_alert }}</p>
					@endif
					@if($prediction->range)
					<p><strong> Global Cues:</strong> {{ $prediction->global_cues }}</p>
					@endif
					@if($prediction->range)
					<p><strong>Market Sentiment:</strong> {{ $prediction->market_sentiment	 }}</p>
					@endif
					@else
					<p class="text-muted">No market prediction available.</p>
					@endif
				</div>
			</div>
			<div class="col-lg-6 d-flex flex-column">
				<div class="card p-3 flex-grow-1 strategy-box mb-4">
					<div class="d-flex justify-content-between align-items-center mb-2">
						<h5 class="mb-0">Daily Strategy Update</h5>
						<a href="{{ route('dashboard.all-strategies') }}" class="view-all-link">View All <i class="fas fa-arrow-right"></i></a>
					</div>
					@if($latestStrategy && $latestStrategy->image_url)
					<img src="{{ asset($latestStrategy->image_url) }}" alt="Strategy Chart" class="rounded mb-3" style="max-height: 300px; object-fit: cover;">
					@else
					<img src="https://placehold.co/600x300/2a2a2a/fff?text=Strategy+Chart" alt="Placeholder Strategy Chart" class="rounded mb-3">
					@endif
					@if($latestStrategy)
					<p>{{ $latestStrategy->description }}</p>
					<p><strong>Strategy Title:</strong> <span class="highlight-green">{{ $latestStrategy->title }}</span></p>
					@else
					<p class="text-muted">No strategy available yet.</p>
					@endif
				</div>
			</div>
		</div>
		<!-- Separate Section for Baskets -->
		<div class="row">
			<div class="col-lg-12">
				<div class="card p-3 flex-grow-1 watchlist_sect">
					<!-- Reusing watchlist_sect for consistent styling -->
					<div class="card-header-with-link">
						<h5>Baskets</h5>
						<!--<a href="#" class="view-all-link">View All <i class="fas fa-arrow-right"></i></a>-->
					</div>

<div class="row">
    @foreach (['Intraday', 'Short Term', 'Long Term'] as $type)
        <div class="col-md-4">
            <div class="basket-item">
                <div class="card-header-with-link">
                    <h6>
                        @if($type === 'Intraday')
                            <i class="fas fa-chart-line custom-info"></i>
                        @elseif($type === 'Short Term')
                            <i class="fas fa-clock custom-warning"></i>
                        @elseif($type === 'Long Term')
                            <i class="fas fa-infinity custom-primary"></i>
                        @endif
                        {{ $type }} Basket
                    </h6>
                    <a href="{{ route('dashboard.all-baskets') }}" class="view-all-link">View All <i class="fas fa-arrow-right"></i></a>
                </div>

                @if (isset($baskets[$type]))
                    @foreach ($baskets[$type]->stocks->take(3) as $stock)
                        <div class="basket-stock">
                            <p><strong>{{ $stock->symbol }}:</strong></p>
                            <p>Buy Price: <span class="value">₹{{ number_format($stock->buy_price, 2) }}</span></p>
                            <p>TGT: <span class="value green">₹{{ number_format($stock->target_price, 2) }}</span></p>
                            <p>SL: <span class="value red">₹{{ number_format($stock->stop_loss, 2) }}</span></p>
                        </div>
                    @endforeach
                @else
                    <div class="basket-stock text-muted">
                        <p>No stocks available.</p>
                    </div>
                @endif
            </div>
        </div>
    @endforeach
</div>

				</div>
			</div>
		</div>
	</div>
	<!-- Center Popup -->
	<div id="centerPopup">
		<div class="popup-header">
			<h4>Ask The Analyst</h4>
			<button id="closePopup">&times;</button>
		</div>
		<div class="popup-body">
			<p>Please feel free to contact us if you need any further information.</p>
			<hr>
			<strong>Business Executive</strong><br>
			📞 7620320782
			</p>
		</div>
	</div>
	<!-- Optional Overlay -->
	<div id="overlay"></div>
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
@endsection