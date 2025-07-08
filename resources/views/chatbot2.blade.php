 @extends('layouts.dashboardLayout')

    @section('title', 'liveChart')

    @section('content')
 <link rel="stylesheet" href="{{ asset('assets/css/bsilTrade.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/chatbot.css') }}">
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

    <div class="chatbot-container">
        <div class="chatbot-header">
            <h2><i class="fas fa-robot"></i> Stock Analysis Bot</h2>
            <div class="stock-selector-container">
                <label for="stockSelectorChat">Analyze:</label>
                <select id="stockSelectorChat" style="width: 100%;"></select>

            </div>
        </div>
        <div class="chatbot-messages" id="chatbox">
            <div class="message bot placeholder">
                <span>Select a stock from the dropdown above to generate the analysis report.</span>
            </div>
        </div>
        </div>
<script>
  const TWELVE_DATA_API_KEY = "e2fb0acfee10401da4f7151094e4e6b2"; // <--- PUT YOUR API KEY HERE

  function loadSymbolsFromApi(exchange) {
    const apiUrl = `https://api.twelvedata.com/stocks?exchange=${exchange}&apikey=${TWELVE_DATA_API_KEY}&show_plan=true`;
  
    $.ajax({
        url: apiUrl,
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            if (!response.data || response.data.length === 0) {
                console.error(`No ${exchange} symbols data received.`);
                alert(`Failed to fetch ${exchange} symbols. Please check the API or your API key.`);
                return;
            }
  
            const dropdown = $('#stockSelectorChat');
  
            // Clear existing options
            dropdown.empty();
  
            // Add options dynamically from the API response
            response.data.forEach(stock => {
                if (stock.exchange === exchange && stock.currency === "INR") {
                    dropdown.append(`<option value="${stock.symbol}">${stock.name}</option>`);
                }
            });
  
            // Initialize Select2 for the dropdown
            dropdown.select2({
                placeholder: `Search for a stock in ${exchange}...`,
                allowClear: true
            });
  
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error(`Failed to fetch ${exchange} symbols:`, textStatus, errorThrown);
            alert(`Error fetching ${exchange} symbols. Please check your network connection or API key.`);
        }
    });
  }
  
  $(document).ready(function () {
    // Load NSE symbols by default
    loadSymbolsFromApi('NSE');
  
    // Handle exchange switch
    $('#exchangeSwitch').on('change', function () {
        const selectedExchange = $(this).val();
        loadSymbolsFromApi(selectedExchange);
    });
  

  });
</script>
            <script src="{{ asset('assets/js/BasilTradeJs/js/chatbot.js') }}"></script>
    </body>
    @endsection