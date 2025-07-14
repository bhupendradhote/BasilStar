<style>
    /*
    IMPORTANT:
    You should ideally extract these styles into a dedicated CSS file (e.g., `header.css` or `app.css`)
    and link it in your main layout file's <head>.
    For now, I'm keeping them here for demonstration, but for production,
    separate CSS is recommended for better maintainability and performance.
    */

    /* Base Body Styles (should be in your main layout's <style> or app.css) */
    body {
        font-family: 'Inter', sans-serif;
        background-color: #f4f7f9;
        margin: 0;
        padding-top: 0; /* Initial padding-top is 0. This will be adjusted by JS for sticky header. */
        transition: padding-top 0.3s ease; /* Smooth transition for body padding */
    }

    /* Header specific styles (applies to the main-header div) */
    #main-header.header-container {
        background-color: #005550; /* Initially transparent to blend with your existing banners */
        position: absolute; /* Positioned over the hero/banner section */
        top: 0;
        left: 0;
        right: 0;
        z-index: 50; /* Ensures header is above other content */
        box-shadow: none; /* No shadow initially */
        transition: background-color 0.3s ease, box-shadow 0.3s ease, position 0.3s ease, top 0.3s ease; /* Smooth transitions for sticky effect */
        width: 100%; /* Ensure it spans full width */
    }

    #main-header.header-scrolled {
        position: fixed; /* Becomes fixed when scrolled */
        background-color: #005550; /* Dark background color when sticky */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        top: 0; /* Ensure it sticks to the very top */
         
    }

    /* Ticker specific styles (now inside the header) */
    .ticker-section {
        background-color: #000; /* Black background for the ticker */
        padding-top: 0.75rem; /* py-3 */
        padding-bottom: 0.75rem; /* py-3 */
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); /* shadow-sm */
    }

    .scroll-container {
        overflow: hidden;
        position: relative;
        width: 100%;
    }

    .scroll-content {
        display: flex;
        white-space: nowrap;
    }

    .scroll-item {
        flex-shrink: 0;
        margin-right: 1.5rem; /* spacing between items */
        padding: 0 0.5rem;
        min-width: 150px;
        display: inline-flex;
        align-items: center;
        color: #fff; /* White text for ticker items */
    }

    .scroll-item span {
        margin-right: 0.25rem;
    }
    .scroll-item span:last-child {
        margin-right: 0;
    }

    @keyframes scroll {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); } /* Adjust if content is less than 200% width */
    }
    .scroll-content.animate {
        animation: scroll 60s linear infinite; /* Adjust duration as needed */
    }
    .scroll-container:hover .scroll-content.animate {
        animation-play-state: paused;
    }

    /* Mobile navigation specific styles */
    .mobile-nav-hidden {
        display: none;
        opacity: 0;
        transform: translateY(-10px);
        transition: opacity 0.3s ease-out, transform 0.3s ease-out;
    }

    .mobile-nav-visible {
        display: block;
        opacity: 1;
        transform: translateY(0);
    }

    /* Media Queries for Responsive Design */
    @media (max-width: 767px) {
        .nav_bar {
            display: none !important;
        }

        #mobile-nav {
            background-color: #1a202c; /* Ensure mobile nav has a background */
        }
        #mobile-nav a,
        #mobile-nav .user-info {
            width: 100%;
            text-align: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid #2d3748;
        }
        #mobile-nav .user-info {
            flex-direction: column;
            align-items: center;
        }
        #mobile-nav .user-info .user-details {
            align-items: center;
        }
        #mobile-nav .logout-button {
            margin-left: 0;
            margin-top: 10px;
        }
    }

    @media (min-width: 768px) {
        .nav_bar {
            display: flex !important;
            flex-direction: row;
        }
    }

    /* Modal Styles (Ensure these are also in a global stylesheet or the main layout file) */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0,0,0,0.4);
        justify-content: center;
        align-items: center;
    }

    .modal-content {
        background-color: #fefefe;
        margin: auto;
        padding: 20px;
        border: 1px solid #888;
        width: 90%;
        max-width: 400px;
        border-radius: 8px;
        position: relative;
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        text-align: center;
    }

    .close-button {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        position: absolute;
        top: 10px;
        right: 15px;
        cursor: pointer;
    }

    .close-button:hover,
    .close-button:focus {
        color: black;
        text-decoration: none;
    }

    .modal-content form {
        display: flex;
        flex-direction: column;
        gap: 15px;
        margin-top: 20px;
        text-align: left;
    }

    .modal-content label {
        font-weight: bold;
        font-size: 0.9em;
        color: #555;
    }

    .modal-content input[type="text"],
    .modal-content input[type="email"],
    .modal-content input[type="password"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    .modal-content button {
        background-color: #4CAF50;
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 1em;
        transition: background-color 0.3s ease;
    }

    .modal-content button:hover {
        background-color: #45a049;
    }

    .form-toggle {
        margin-top: 15px;
        font-size: 0.9em;
        color: #555;
    }

    .form-toggle a {
        color: #007bff;
        text-decoration: none;
        cursor: pointer;
    }

    .form-toggle a:hover {
        text-decoration: underline;
    }

    #signupForm {
        display: none;
    }

    .error-message {
        color: #e3342f;
        font-size: 0.8em;
        margin-top: 5px;
        text-align: left;
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 0.9em;
        color: #333;
    }

    .user-info .user-details {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    .user-info .user-name {
        font-weight: bold;
    }

    .logout-button {
        background-color: #f44336;
        color: white;
        padding: 8px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 0.9em;
        transition: background-color 0.3s ease;
        margin-left: 20px;
    }

    .logout-button:hover {
        background-color: #d32f2f;
    }
</style>

<header id="main-header" class="header-container w-full">
    {{-- Stock Ticker - MOVED TO THE TOP --}}
    <section class="ticker-section">
        <div class="max-w-7xl mx-auto px-4"> {{-- Use max-w-7xl and mx-auto to match header width --}}
            <div class="scroll-container">
                <div id="stock-ticker-content" class="scroll-content animate">
                    {{-- Stock ticker items will be loaded here by JS --}}
                    <div class="scroll-item text-gray-600">Loading stock data...</div>
                    {{-- Duplicate content for seamless looping --}}
                    <div class="scroll-item text-gray-600">Loading stock data...</div>
                </div>
            </div>
        </div>
    </section>

    {{-- Main Navigation Bar (now below the ticker) --}}
    <div class="max-w-7xl mx-auto py-4 px-4 flex items-center justify-between">
        <div class="flex items-center">
            <a href="/" class="flex items-center space-x-2">
                <img class="w-[100px]" src="{{ asset('assets/img/logo/green.png') }}" alt="Basil Star Logo">
            </a>
        </div>

        <nav class="nav_bar text-white hidden md:flex items-center space-x-8 text-base font-medium">
            <a href="/" class="hover:text-green-400 transition duration-200">Home</a>
            <a href="/about" class="hover:text-green-400 transition duration-200">About Us</a>
            <a href="/all_news" class="hover:text-green-400 transition duration-200">News</a>
            <a href="/TradingDashboard" class="hover:text-green-400 transition duration-200">Equity Screener</a>
            <a href="/liveChart" class="hover:text-blue-600 transition duration-200">BasilTrade</a>
            <a href="/contact" class="hover:text-green-400 transition duration-200">Contact</a>
            
            
        </nav>

        <div class="hidden md:flex items-center">
            @auth
                <div class="user-info flex items-center gap-4 text-white">
                    <div class="user-details flex flex-col items-end text-sm">
                        <span class="user-name font-bold">{{ Auth::user()->name }}</span>
                        <span class="text-xs text-gray-300">{{ Auth::user()->email }}</span>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" id="logout-form">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-full transition duration-200 text-sm">Logout</button>
                    </form>
                </div>
            @else
                <a href="#" 
   id="openLoginModal" 
   class="bg-[#51fcb1] hover:bg-[#45e0a0] text-[#0f443f] py-3 px-6 rounded-full transition duration-200 text-sm font-semibold whitespace-nowrap">
   Login Now
</a>
            @endauth
        </div>

        <div class="md:hidden">
            <button id="mobileMenuButton" class="text-white hover:text-gray-300 focus:outline-none">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
            </button>
        </div>
    </div>

    <nav id="mobile-nav" class="mobile-nav-hidden text-white md:hidden bg-[#1a202c] w-full absolute top-full left-0 shadow-lg">
        <a href="/" class="block py-3 px-4 text-center hover:bg-gray-700">Home</a>
        <a href="/about" class="block py-3 px-4 text-center hover:bg-gray-700">About Us</a>
        <a href="/all_news" class="block py-3 px-4 text-center hover:bg-gray-700">News</a>
        <a href="/TradingDashboard" class="block py-3 px-4 text-center hover:bg-gray-700">Equity Screener</a>
        <a href="/liveChart" class="block py-3 px-4 text-center hover:bg-gray-700">Basil Trade</a>
        @auth
            <div class="user-info flex flex-col items-center py-3 px-4 text-white border-t border-gray-700 mt-2 pt-2">
                <span class="user-name font-bold">{{ Auth::user()->name }}</span>
                <span class="text-xs text-gray-300">{{ Auth::user()->email }}</span>
                <form action="{{ route('logout') }}" method="POST" id="logout-form-mobile" class="mt-2">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-full transition duration-200 text-sm">Logout</button>
                </form>
            </div>
        @else
            <a href="#" id="openLoginModalMobile" class="block py-3 px-4 text-center bg-green-600 hover:bg-green-700 text-white text-sm font-semibold whitespace-nowrap mt-2">Login / SignUp</a>
        @endauth
    </nav>
</header>

<div id="loginSignupModal" class="modal">
    <div class="modal-content">
        <span class="close-button">&times;</span>

        <div id="loginForm">
            <h2>Login</h2>
            <form action="{{ route('login') }}" method="POST">
                @csrf

                {{-- Laravel specific error handling --}}
                @if ($errors->has('email') && old('_token') && request()->routeIs('login'))
                    <p class="error-message">{{ $errors->first('email') }}</p>
                @endif

                <div>
                    <label for="login_email">Email:</label>
                    <input type="email" id="login_email" name="email" value="{{ old('email') }}" required>
                </div>
                <div>
                    <label for="login_password">Password:</label>
                    <input type="password" id="login_password" name="password" required>
                </div>
                <button type="submit">Login</button>
            </form>
            <p class="form-toggle">
                Don't have an account? <a href="#" id="showSignup">Sign Up</a>
            </p>
        </div>

        <div id="signupForm" style="display: none;">
            <h2>Sign Up</h2>
            <form action="{{ route('register') }}" method="POST">
                @csrf

                {{-- Laravel specific error handling --}}
                @if ($errors->any() && old('_token') && request()->routeIs('register'))
                    <div class="error-message">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div>
                    <label for="signup_name">Name:</label>
                    <input type="text" id="signup_name" name="name" value="{{ old('name') }}" required>
                    @error('name') <p class="error-message">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="signup_email">Email:</label>
                    <input type="email" id="signup_email" name="email" value="{{ old('email') }}" required>
                    @error('email') <p class="error-message">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="signup_password">Password:</label>
                    <input type="password" id="signup_password" name="password" required>
                    @error('password') <p class="error-message">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="signup_password_confirmation">Confirm Password:</label>
                    <input type="password" id="signup_password_confirmation" name="password_confirmation" required>
                    @error('password_confirmation') <p class="error-message">{{ $message }}</p> @enderror
                </div>
                <button type="submit">Sign Up</button>
            </form>
            <p class="form-toggle">
                Already have an account? <a href="#" id="showLogin">Login</a>
            </p>
        </div>
    </div>
</div>

<script>
    // Get all necessary elements for Header and Modal
    var modal = document.getElementById("loginSignupModal");
    var btn = document.getElementById("openLoginModal"); // Desktop Login/Signup button
    var span = document.getElementsByClassName("close-button")[0];
    var loginFormDiv = document.getElementById("loginForm");
    var signupFormDiv = document.getElementById("signupForm");
    var showSignupLink = document.getElementById("showSignup");
    var showLoginLink = document.getElementById("showLogin");

    var mainHeader = document.getElementById('main-header');
    var mobileMenuButton = document.getElementById('mobileMenuButton');
    var mobileNav = document.getElementById('mobile-nav'); // The mobile nav element
    var openLoginModalMobileBtn = document.getElementById("openLoginModalMobile"); // Mobile Login/Signup button


    // --- Modal Functions ---
    function showLoginForm() {
        loginFormDiv.style.display = "block";
        signupFormDiv.style.display = "none";
    }

    function showSignupForm() {
        loginFormDiv.style.display = "none";
        signupFormDiv.style.display = "block";
    }

    // --- Event Listeners for Modal ---

    // Open modal on page load if there are validation errors (Laravel specific)
    window.onload = function() {
        const urlParams = new URLSearchParams(window.location.search);
        const hasErrors = urlParams.has('errors');
        // Check if a login or register attempt was made (Laravel specific)
        const wasLoginAttempt = {{ json_encode(old('_token') && request()->routeIs('login')) }};
        const wasRegisterAttempt = {{ json_encode(old('_token') && request()->routeIs('register')) }};

        if (hasErrors || wasLoginAttempt || wasRegisterAttempt) {
            modal.style.display = "flex";

            if (wasRegisterAttempt || (hasErrors && signupFormDiv.style.display !== 'none' && !wasLoginAttempt)) {
                showSignupForm();
            } else {
                showLoginForm();
            }
        }
    };

    // Open modal when desktop "Get a Quote" (Login/Signup) button is clicked
    if (btn) {
        btn.onclick = function(event) {
            event.preventDefault(); // Prevent default link behavior
            modal.style.display = "flex";
            showLoginForm(); // Show login form by default
        }
    }

    // Close modal when 'x' is clicked
    if (span) {
        span.onclick = function() {
            modal.style.display = "none";
            document.querySelectorAll('.error-message').forEach(el => el.style.display = 'none'); // Clear errors
            mobileNav.classList.remove('mobile-nav-visible'); // Ensure mobile nav is hidden
            mobileNav.classList.add('mobile-nav-hidden');
        }
    }

    // Close modal when clicking outside of it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
            mobileNav.classList.remove('mobile-nav-visible'); // Ensure mobile nav is hidden
            mobileNav.classList.add('mobile-nav-hidden');
        }
    }

    // Toggle to signup form
    if (showSignupLink) {
        showSignupLink.onclick = function(event) {
            event.preventDefault();
            showSignupForm();
        }
    }

    // Toggle back to login form
    if (showLoginLink) {
        showLoginLink.onclick = function(event) {
            event.preventDefault();
            showLoginForm();
        }
    }

    // --- Sticky Header Functionality (combined header + ticker) ---
    window.addEventListener('scroll', function() {
        const scrollThreshold = 50; // Pixels to scroll before header becomes sticky
        if (window.scrollY > scrollThreshold) {
            mainHeader.classList.add('header-scrolled');
            // Adjust body padding-top to prevent content jump, based on combined header height
            document.body.style.paddingTop = mainHeader.offsetHeight + 'px';
        } else {
            mainHeader.classList.remove('header-scrolled');
            document.body.style.paddingTop = '0';
        }
    });

    // --- Mobile Menu Functionality ---
    if (mobileMenuButton) {
        mobileMenuButton.addEventListener('click', function() {
            mobileNav.classList.toggle('mobile-nav-hidden');
            mobileNav.classList.toggle('mobile-nav-visible');
        });
    }

    // Open modal when mobile "Login / SignUp" button is clicked
    if (openLoginModalMobileBtn) {
        openLoginModalMobileBtn.onclick = function(event) {
            event.preventDefault();
            modal.style.display = "flex";
            showLoginForm(); // Show login form by default
            mobileNav.classList.remove('mobile-nav-visible'); // Hide mobile nav when modal opens
            mobileNav.classList.add('mobile-nav-hidden');
        }
    }

    // --- Ticker Animation Initialization (from news.js or here) ---
    document.addEventListener('DOMContentLoaded', function() {
        const scrollContent = document.getElementById('stock-ticker-content');
        if (scrollContent) {
            // Duplicate content to ensure seamless loop
            const originalContent = scrollContent.innerHTML;
            // Only duplicate if the content isn't empty, as news.js might populate it late
            if (originalContent.trim() !== '<div class="scroll-item text-gray-600">Loading stock data...</div>') {
                scrollContent.innerHTML += originalContent; // Double the content
            } else {
                // If it's still "Loading", news.js will populate.
                // We might need to ensure news.js's fetch populates twice or handle duplication after fetch.
                // For now, assume news.js handles initial population. You might call this duplication
                // logic again after news.js has loaded the real data.
            }

            // Add 'animate' class to start CSS animation
            scrollContent.classList.add('animate');
        }
    });
</script>