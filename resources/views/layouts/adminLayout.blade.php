<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Basil Star - Admin Dashboard</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/BasilFav.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .sidebar-fixed {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 50;
        }
        
        .sidebar-item {
            color: #4b5563;
            font-weight: 500;
        }
        
        .sidebar-item:hover {
            background-color: #f3f4f6;
            color: #1f2937;
        }
        
        .sidebar-item.active {
            background-color: #eff6ff;
            color: #3b82f6;
        }
        
        .sidebar-item.active i {
            color: #3b82f6;
        }
        
        .sidebar-item i {
            transition: color 0.2s ease;
        }
        
        .sidebar-item:hover i {
            color: #1f2937;
        }
        
        .market-up { color: #10b981; }
        .market-down { color: #ef4444; }
        
        #adminHeader {
            height: 64px;
            transition: width 0.3s ease, margin-left 0.3s ease;
            position: fixed;
            top: 0;
            z-index: 40;
        }
        
        #mainContent {
            margin-top: 64px;
            transition: margin-left 0.3s ease;
        }
        
        /* Collapsed sidebar styles */
        .sidebar-collapsed #sidebar {
            width: 80px;
            overflow: hidden;
        }
        
        .sidebar-collapsed #sidebar .sidebar-header-toggle {
            justify-content: center;
        }
        
        .sidebar-collapsed #sidebar #sidebar-header-text,
        .sidebar-collapsed #sidebar #sidebar-user-info,
        .sidebar-collapsed #sidebar #sidebar-settings-text,
        .sidebar-collapsed #sidebar .sidebar-item span,
        .sidebar-collapsed #sidebar .sidebar-item .fa-chevron-down {
            display: none;
        }

        .sidebar-collapsed #sidebar .sidebar-toggle-button-collapsed {
            display: block;
        }

        .sidebar-collapsed #sidebar .sidebar-header-brand,
        .sidebar-collapsed #sidebar .sidebar-header-close-button {
            display: none;
        }
        
        .sidebar-collapsed #sidebar .sidebar-item {
            justify-content: center;
        }
        
        .sidebar-collapsed #sidebar .sidebar-item i {
            margin-right: 0;
        }
        
        .sidebar-collapsed #mainContent {
            margin-left: 80px;
        }
        
        /* Expanded sidebar styles */
        .sidebar-expanded #sidebar {
            width: 256px;
        }

        .sidebar-expanded #sidebar .sidebar-toggle-button-collapsed {
            display: none;
        }

        .sidebar-expanded #sidebar .sidebar-header-brand,
        .sidebar-expanded #sidebar .sidebar-header-close-button {
            display: flex;
        }
        
        .sidebar-expanded #mainContent {
            margin-left: 256px;
        }

        .sidebar-expanded #sidebar .pl-8 {
            padding-left: 1.2rem;
        }
        .sidebar-collapsed #sidebar .pl-8 {
            display: none;
        }

        .fa-chevron-down.rotate-180 {
            transform: rotate(180deg);
        }
        
        /* Mobile sidebar */
        .mobile-sidebar-open #sidebar {
            transform: translateX(0);
        }
        
        .mobile-sidebar-open #sidebar-overlay {
            display: block;
        }

        @media (max-width: 767px) {
            #adminHeader {
                width: 100% !important;
                margin-left: 0 !important;
            }
            #mainContent {
                margin-left: 0 !important;
            }
        }
    </style>
</head>
<body class="bg-gray-50 sidebar-expanded">
    <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden md:hidden"></div>
    
    <aside id="sidebar" class="sidebar-fixed w-64 h-screen bg-white shadow-lg transform -translate-x-full md:translate-x-0 transition-all duration-200 ease-in-out z-50">
        <div class="flex items-center justify-between p-4 border-b sidebar-header-toggle">
            <div class="flex items-center space-x-2 sidebar-header-brand">
                <i class="fas fa-chart-line text-blue-500 text-2xl"></i>
                <span id="sidebar-header-text" class="text-xl font-bold text-gray-800">FundFlow Pro</span>
            </div>
            <button class="md:hidden text-gray-500 sidebar-toggle-mobile">
                <i class="fas fa-bars"></i>
            </button>
            <button class="hidden md:block text-gray-500 p-2 rounded-full hover:bg-gray-100 sidebar-toggle-desktop">
                <i class="fas fa-bars"></i>
            </button>
        </div>
        
        <div class="p-4">
            <div class="flex items-center space-x-3 p-3 rounded-lg bg-gray-50 mb-4">
                <img src="https://ui-avatars.com/api/?name=Admin+User&background=3b82f6&color=fff" alt="User" class="w-10 h-10 rounded-full">
                <div id="sidebar-user-info">
                    <p class="font-medium text-gray-800">Admin User</p>
                    <p class="text-xs text-gray-500">Administrator</p>
                </div>
            </div>
            
            <nav class="space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-item flex items-center space-x-3 p-3 rounded-lg transition active">
                    <i class="fas fa-tachometer-alt text-gray-500 w-5"></i>
                    <span>Dashboard</span>
                </a>
                
                <!-- Market Prediction Dropdown -->
                <div class="relative">
                    <button class="sidebar-item sidebar-dropdown-btn flex items-center justify-between w-full space-x-3 p-3 rounded-lg transition" data-target="marketPredictionDropdown">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-chart-line text-gray-500 w-5"></i>
                            <span>Market Prediction</span>
                        </div>
                        <i class="fas fa-chevron-down text-xs transform transition-transform duration-200"></i>
                    </button>
                    <div id="marketPredictionDropdown" class="hidden pl-8 pr-3 py-1 space-y-1">
                        <a href="{{ route('admin.market-prediction.create') }}" class="flex items-center space-x-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                            <i class="fas fa-plus-circle text-gray-500"></i>
                            <span>Add MarketPrediction</span>
                        </a>

                        <a href="{{ route('admin.market-prediction.index') }}" class="flex items-center space-x-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                            <i class="fas fa-list text-gray-500"></i>
                            <span>MarketPredictions List</span>
                        </a>
                    </div>
                </div>
                
                <!-- Portfolio Dropdown -->
                <div class="relative">
                    <button class="sidebar-item sidebar-dropdown-btn flex items-center justify-between w-full space-x-3 p-3 rounded-lg transition" data-target="portfolioDropdown">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-chart-pie text-gray-500 w-5"></i>
                            <span>Portfolio</span>
                        </div>
                        <i class="fas fa-chevron-down text-xs transform transition-transform duration-200"></i>
                    </button>
                    <div id="portfolioDropdown" class="hidden pl-8 pr-3 py-1 space-y-1">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">Holdings</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">Performance</a>
                    </div>
                </div>
                
                <!-- Daily Strategy Dropdown -->
                <div class="relative">
                    <button class="sidebar-item sidebar-dropdown-btn flex items-center justify-between w-full space-x-3 p-3 rounded-lg transition" data-target="dailyStrategyDropdown">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-chart-pie text-gray-500 w-5"></i>
                            <span>Daily Strategy</span>
                        </div>
                        <i class="fas fa-chevron-down text-xs transform transition-transform duration-200"></i>
                    </button>
                    <div id="dailyStrategyDropdown" class="hidden pl-8 pr-3 py-1 space-y-1">
                       <a href="{{ route('admin.strategy.create') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">Add Daily Strategy</a>
                       <a href="{{ route('admin.strategy.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">Manage Daily Strategy</a>
                    </div>
                </div>
                
                <!-- Baskets Dropdown -->
                <div class="relative">
                    <button class="sidebar-item sidebar-dropdown-btn flex items-center justify-between w-full space-x-3 p-3 rounded-lg transition" data-target="basketsDropdown">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-chart-pie text-gray-500 w-5"></i>
                            <span>Baskets</span>
                        </div>
                        <i class="fas fa-chevron-down text-xs transform transition-transform duration-200"></i>
                    </button>
                    <div id="basketsDropdown" class="hidden pl-8 pr-3 py-1 space-y-1">
                        <a href="{{ route('admin.basket.create') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">Add Baskets</a>
                        <a href="{{ route('admin.basket.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">Manage Baskets</a>
                    </div>
                </div>
                
                <a href="#" class="sidebar-item flex items-center space-x-3 p-3 rounded-lg transition">
                    <i class="fas fa-exchange-alt text-gray-500 w-5"></i>
                    <span>Transactions</span>
                </a>
                
                <a href="#" class="sidebar-item flex items-center space-x-3 p-3 rounded-lg transition">
                    <i class="fas fa-users text-gray-500 w-5"></i>
                    <span>Clients</span>
                </a>
            </nav>
        </div>
        
        <div class="absolute bottom-0 left-0 right-0 p-4 border-t">
            <form method="POST" action="#">
                <button type="submit" class="w-full flex items-center space-x-3 p-3 rounded-lg text-red-500 hover:bg-red-50 transition">
                    <i class="fas fa-sign-out-alt w-5"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>
    
    <header id="adminHeader" class="bg-white shadow-sm fixed top-0 w-full z-40 transition-all duration-200 ease-in-out">
        <div class="flex items-center justify-between px-4 py-3">
            <div class="flex items-center space-x-4">
                <div class="relative hidden md:block">
                    <input type="text" placeholder="Search funds, clients..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent w-64">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
            </div>
            
            <div class="flex items-center space-x-4">
                <div class="hidden lg:flex items-center space-x-4 mr-4">
                    <div class="text-sm">
                        <span class="font-medium">S&P 500:</span>
                        <span class="market-up">4,567.89 <i class="fas fa-caret-up"></i> 0.45%</span>
                    </div>
                    <div class="text-sm">
                        <span class="font-medium">NASDAQ:</span>
                        <span class="market-down">14,210.34 <i class="fas fa-caret-down"></i> 0.23%</span>
                    </div>
                    <div class="text-sm">
                        <span class="font-medium">DJIA:</span>
                        <span class="market-up">35,678.12 <i class="fas fa-caret-up"></i> 0.67%</span>
                    </div>
                </div>
                
                <div class="relative">
                    <button style="display:none;" class="header-dropdown-btn relative p-2 text-gray-500 hover:text-gray-700 focus:outline-none" data-target="notificationDropdown">
                        <i class="fas fa-bell"></i>
                        <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
                    </button>
                    <div id="notificationDropdown" class="hidden absolute right-0 mt-2 w-64 bg-white rounded-md shadow-lg py-1 z-50">
                        <div class="px-4 py-2 text-sm text-gray-700 font-semibold border-b">Notifications</div>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <div class="font-medium">New client registered</div>
                            <div class="text-xs text-gray-500">2 hours ago</div>
                        </a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <div class="font-medium">System update available</div>
                            <div class="text-xs text-gray-500">Yesterday</div>
                        </a>
                        <a href="#" class="block px-4 py-2 text-sm text-blue-600 hover:bg-gray-100 text-center">View all notifications</a>
                    </div>
                </div>
                
                <div class="relative">
                    <button style="display:none;"  class="header-dropdown-btn relative p-2 text-gray-500 hover:text-gray-700 focus:outline-none" data-target="messageDropdown">
                        <i class="fas fa-envelope"></i>
                        <span class="absolute top-0 right-0 w-2 h-2 bg-blue-500 rounded-full"></span>
                    </button>
                    <div id="messageDropdown" class="hidden absolute right-0 mt-2 w-64 bg-white rounded-md shadow-lg py-1 z-50">
                        <div class="px-4 py-2 text-sm text-gray-700 font-semibold border-b">Messages</div>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <div class="font-medium">John Doe <span class="text-xs text-gray-500 float-right">10:30 AM</span></div>
                            <div class="text-xs text-gray-500 truncate">Regarding your recent inquiry...</div>
                        </a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <div class="font-medium">Jane Smith <span class="text-xs text-gray-500 float-right">Yesterday</span></div>
                            <div class="text-xs text-gray-500 truncate">Meeting scheduled for next week...</div>
                        </a>
                        <a href="#" class="block px-4 py-2 text-sm text-blue-600 hover:bg-gray-100 text-center">View all messages</a>
                    </div>
                </div>
                
                <div class="relative">
                    <button class="header-dropdown-btn flex items-center space-x-2 focus:outline-none" data-target="userDropdown">
                        <img src="https://ui-avatars.com/api/?name=Admin+User&background=3b82f6&color=fff" alt="User" class="w-8 h-8 rounded-full">
                        <span class="hidden md:inline text-sm font-medium">Admin User</span>
                        <i class="fas fa-chevron-down text-xs text-gray-500 hidden md:inline"></i>
                    </button>
                    
                    <div id="userDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Your Profile</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                        <form method="POST" action="#">
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>
    
    <main id="mainContent" class="transition-all duration-200 ease-in-out">
        @yield('content')
    </main>

    <script>
        $(document).ready(function() {
            // Initialize sidebar state from localStorage
            const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            if (isCollapsed) {
                $('body').addClass('sidebar-collapsed').removeClass('sidebar-expanded');
            }
            
            // Initialize charts
            initCharts();
            
            // Adjust layout based on sidebar state
            adjustLayout();
            
            // Toggle mobile sidebar
            $('.sidebar-toggle-mobile').on('click', function(e) {
                e.stopPropagation();
                $('body').toggleClass('mobile-sidebar-open');
            });
            
            // Close mobile sidebar when clicking overlay
            $('#sidebar-overlay').on('click', function() {
                $('body').removeClass('mobile-sidebar-open');
            });
            
            // Toggle desktop sidebar collapse
            $('.sidebar-toggle-desktop').on('click', function(e) {
                e.stopPropagation();
                toggleSidebarCollapse();
            });
            
            // Header dropdown functionality
            $('.header-dropdown-btn').on('click', function(e) {
                e.stopPropagation();
                const target = $(this).data('target');
                
                // Close all other dropdowns
                $('.header-dropdown-btn').not(this).each(function() {
                    const otherTarget = $(this).data('target');
                    $(`#${otherTarget}`).addClass('hidden');
                });
                
                // Toggle current dropdown
                $(`#${target}`).toggleClass('hidden');
            });
            
            // Sidebar dropdown functionality
            $('.sidebar-dropdown-btn').on('click', function(e) {
                e.stopPropagation();
                
                // Don't open dropdowns if sidebar is collapsed
                if ($('body').hasClass('sidebar-collapsed')) return;
                
                const target = $(this).data('target');
                const chevron = $(this).find('.fa-chevron-down');
                
                // Close all other dropdowns
                $('.sidebar-dropdown-btn').not(this).each(function() {
                    const otherTarget = $(this).data('target');
                    $(`#${otherTarget}`).addClass('hidden');
                    $(this).removeClass('active');
                    $(this).find('.fa-chevron-down').removeClass('rotate-180');
                });
                
                // Toggle current dropdown
                $(`#${target}`).toggleClass('hidden');
                $(this).toggleClass('active');
                chevron.toggleClass('rotate-180');
            });
            
            // Close all dropdowns when clicking outside
            $(document).on('click', function() {
                $('.header-dropdown-btn').each(function() {
                    const target = $(this).data('target');
                    $(`#${target}`).addClass('hidden');
                });
                
                // Only close sidebar dropdowns if sidebar is not collapsed
                if (!$('body').hasClass('sidebar-collapsed')) {
                    $('.sidebar-dropdown-btn').each(function() {
                        const target = $(this).data('target');
                        $(`#${target}`).addClass('hidden');
                        $(this).removeClass('active');
                        $(this).find('.fa-chevron-down').removeClass('rotate-180');
                    });
                }
            });
            
            // Prevent dropdowns from closing when clicking inside them
            $('.relative > div').on('click', function(e) {
                e.stopPropagation();
            });
            
            // Window resize handler
            $(window).on('resize', adjustLayout);
        });
        
        // Function to toggle sidebar collapse
        function toggleSidebarCollapse() {
            $('body').toggleClass('sidebar-collapsed').toggleClass('sidebar-expanded');
            
            // Save preference to localStorage
            const isCollapsed = $('body').hasClass('sidebar-collapsed');
            localStorage.setItem('sidebarCollapsed', isCollapsed);

            adjustLayout();
        }
        
        // Function to adjust layout based on sidebar state
        function adjustLayout() {
            const isCollapsed = $('body').hasClass('sidebar-collapsed');
            const sidebarWidth = isCollapsed ? 80 : 256;
            
            // Handle chevron visibility
            $('.sidebar-dropdown-btn .fa-chevron-down').toggleClass('hidden', isCollapsed);
            
            // Close sidebar dropdowns when collapsing
            if (isCollapsed) {
                $('.sidebar-dropdown-btn').each(function() {
                    const target = $(this).data('target');
                    $(`#${target}`).addClass('hidden');
                    $(this).removeClass('active');
                    $(this).find('.fa-chevron-down').removeClass('rotate-180');
                });
            }
            
            // Only apply these styles on desktop (md breakpoint and above)
            if ($(window).width() >= 768) {
                $('#adminHeader').css({
                    'width': `calc(100% - ${sidebarWidth}px)`,
                    'margin-left': `${sidebarWidth}px`
                });
                $('#mainContent').css('margin-left', `${sidebarWidth}px`);
            } else {
                // Reset styles for mobile
                $('#adminHeader').css({
                    'width': '100%',
                    'margin-left': '0'
                });
                $('#mainContent').css('margin-left', '0');
            }
        }
        
        // Initialize charts
        function initCharts() {
            // Performance Chart
            const performanceCtx = $('#performanceChart');
            if (performanceCtx.length) {
                new Chart(performanceCtx[0].getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                        datasets: [
                            {
                                label: 'Portfolio',
                                data: [10000, 10500, 11000, 10700, 11500, 12000, 12500, 13000, 13500, 14000, 14500, 15000],
                                borderColor: '#3b82f6',
                                backgroundColor: 'rgba(59, 130, 246, 0.05)',
                                borderWidth: 2,
                                tension: 0.3,
                                fill: true
                            },
                            {
                                label: 'Benchmark',
                                data: [10000, 10200, 10400, 10600, 10800, 11000, 11200, 11400, 11600, 11800, 12000, 12200],
                                borderColor: '#94a3b8',
                                borderWidth: 2,
                                borderDash: [5, 5],
                                tension: 0.3
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            tooltip: {
                                mode: 'index',
                                intersect: false,
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: false,
                                ticks: {
                                    callback: function(value) {
                                        return '$' + value.toLocaleString();
                                    }
                                }
                            }
                        }
                    }
                });
            }
            
            // Portfolio Allocation Chart
            const portfolioCtx = $('#portfolioChart');
            if (portfolioCtx.length) {
                new Chart(portfolioCtx[0].getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: ['Stocks', 'Bonds', 'Real Estate', 'Cash', 'Commodities', 'Crypto'],
                        datasets: [{
                            data: [35, 25, 15, 10, 10, 5],
                            backgroundColor: [
                                '#3b82f6',
                                '#10b981',
                                '#f59e0b',
                                '#94a3b8',
                                '#f97316',
                                '#8b5cf6'
                            ],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'right',
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const label = context.label || '';
                                        const value = context.raw || 0;
                                        return `${label}: ${value}%`;
                                    }
                                }
                            }
                        },
                        cutout: '70%'
                    }
                });
            }
        }
    </script>
</body>
</html>