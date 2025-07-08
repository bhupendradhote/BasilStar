<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- SEO -->
    <meta name="keywords" content="mobile banking, business consulting, bank loans, credit cards, finance, insurance, broker business, forex trading">
    <meta name="description" content="Basil-star – is a clean, modern and responsive design for finance, insurance, and banking websites.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Basil-star</title>

    <!-- OG Tags -->
    <meta property="og:site_name" content="Basil-star">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Basil-star">
    <meta property="og:image" content="{{ asset('images/assets/ogg.png') }}">

    <!-- Tab & Mobile Colors -->
    <meta name="theme-color" content="#913BFF">
    <meta name="msapplication-navbutton-color" content="#913BFF">
    <meta name="apple-mobile-web-app-status-bar-style" content="#913BFF">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/BasilFav.png') }}">
    <link rel="icon" href="data:,"> 
    
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Fira+Code:wght@400;500&display=swap" rel="stylesheet">

  		<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
		<script src="https://unpkg.com/lightweight-charts/dist/lightweight-charts.standalone.production.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/chartjs-chart-financial"></script>
		<script src="https://cdn.jsdelivr.net/npm/luxon@3.0.1"></script>
		<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-luxon@1.2.0"></script>
		<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
		<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet" />
		<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>
		<link rel="stylesheet" href="{{ asset('assets/css/bsilTrade.css') }}">

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/lightweight-charts@4.1.1/dist/lightweight-charts.standalone.production.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
</head>

<body>

    @include('components.headerDashboard')

    <div class="layout-wrapper">
        <main class="main-content">
            @yield('content')
        </main>
    </div>
    

		<script src="{{ asset('assets/js/BasilTradeJs/js/chart.js') }}"></script>
        <script src="{{ asset('assets/js/BasilTradeJs/js/stockLatest.js') }}"></script>
        <script src="{{ asset('assets/js/BasilTradeJs/js/analyzeMarketExtras.js') }}"></script>
        <script src="{{ asset('assets/js/BasilTradeJs/js/stockPast.js') }}"></script>
        <script src="{{ asset('assets/js/BasilTradeJs/js/trendOscillators.js') }}"></script>
        <script src="{{ asset('assets/js/BasilTradeJs/js/stockChangeDescription.js') }}"></script>
        <script src="{{ asset('assets/js/BasilTradeJs/js/pivotTableRenderer.js') }}"></script>
        <script src="{{ asset('assets/js/BasilTradeJs/js/pivotCalculations.js') }}"></script>
        <script src="{{ asset('assets/js/BasilTradeJs/js/oscillatorAnalysis.js') }}"></script>
        <script src="{{ asset('assets/js/BasilTradeJs/js/news.js') }}"></script>
		
            <script src="{{ asset('assets/js/BasilTradeJs/js/fundamentals/displayStockStatistics.js') }}"></script>
        <script src="{{ asset('assets/js/BasilTradeJs/js/fundamentals/dividentsSplitData.js') }}"></script>
        <script src="{{ asset('assets/js/BasilTradeJs/js/fundamentals/IncomeStatement.js') }}"></script>
        <script src="{{ asset('assets/js/BasilTradeJs/js/fundamentals/balanceSheetData.js') }}"></script>
        <script src="{{ asset('assets/js/BasilTradeJs/js/fundamentals/companyProfile.js') }}"></script>
        <script src="{{ asset('assets/js/BasilTradeJs/js/fundamentals/fetchCashFlowData.js') }}"></script>
  <!--      <script src="{{ asset('assets/js/BasilTradeJs/js/fundamentals/fetchQuoteData.js') }}"></script>-->
  <!--<script src="{{ asset('assets/js/BasilTradeJs/js/fundamentals/institutionalOwnership.js') }}"></script>-->
  
        <script src="{{ asset('assets/js/BasilTradeJs/js/fundamentals/fetchMarketMovers.js') }}"></script>
        <script src="{{ asset('assets/js/BasilTradeJs/js/fundamentals/fetchEarningsData.js') }}"></script>

		<script src="{{ asset('assets/js/BasilTradeJs/js/main.js') }}"></script>

</body>
</html>
