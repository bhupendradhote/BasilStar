<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Financial Dashboard UI')</title> {{-- Dynamic title --}}
      <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/BasilFav.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f7f9;
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
            margin-right: 1.5rem;
            padding: 0 0.5rem;
            min-width: 150px;
            display: inline-flex;
            align-items: center;
            color: #fff;
        }

        .scroll-item span {
             margin-right: 0.25rem;
        }
         .scroll-item span:last-child {
             margin-right: 0;
        }

        /* Specific width adjustments potentially needed in content file */
        .india_news, .my_watchl {
            width: 23% !important; /* These might need adjustment based on the grid layout */
        }
        .pred_sect {
            width: 50% !important; /* These might need adjustment based on the grid layout */
        }
        #business-news-container h3{
            font-size: 14px;
        }

        #business-news-container .text-sm {
            font-size: 11.5px;
            line-height: 15px;
        }

        @keyframes scroll {
            0% {
                transform: translateX(0);
            }
            100% {
                transform: translateX(-50%);
            }
        }

        .scroll-container:hover .scroll-content {
            animation-play-state: paused;
        }

        .dropdown:hover .dropdown-menu {
            display: block;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            z-index: 10;
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 0.5rem 0;
            min-width: 160px;
        }

        .dropdown-menu a {
            display: block;
            padding: 0.5rem 1rem;
            color: #4a5568;
            text-decoration: none;
            transition: background-color 0.2s ease;
        }

        .dropdown-menu a:hover {
            background-color: #f4f7f9;
        }
        #business-news-container .para{
            display: none; /* Assuming this is hidden by default and shown via JS */
        }

         .india-news-section {
             width: 200px; /* Specific width adjustment - potentially overridden by grid */
             flex-shrink: 0;
         }

        /* The lg:grid-cols-custom class from the original HTML is tricky in a layout
           as it affects the main content grid. It's better to apply the grid
           directly in the content file or use a more flexible approach.
           Keeping it commented out here as a reminder. */
        /*
        @media (min-width: 1024px) {
             .lg\:grid-cols-custom {
                 grid-template-columns: 200px repeat(auto-fit, minmax(250px, 1fr));
             }
        }
        */
        
        .footer-bg {
    background-color: #1F3F3E; /* Dark green/teal */
}

/* Email input specific styles */
.footer-email-input {
    background-color: #ffffff; /* White background for input */
    color: #1a202c; /* Dark text for input */
    padding: 0.75rem 1rem;
    border-radius: 0.375rem; /* rounded-md */
    border: none;
    width: 100%;
}

.footer-email-input::placeholder {
    color: #4A5568; /* Darker gray placeholder */
}

.footer-email-input:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.5); /* Green glow */
}

/* Subscribe button gradient */
.subscribe-btn-gradient {
    background: linear-gradient(to right, #005550, #52fcb1);
    transition: opacity 0.3s ease;
}

.subscribe-btn-gradient:hover {
    opacity: 0.9;
}

/* Footer link styles */
.footer-link {
    color: #A0AEC0; /* Light gray for links */
    transition: color 0.3s ease;
}

.footer-link:hover {
    color: #4CAF50; /* Green on hover */
}

/* Contact info icon circle */
.contact-icon-circle {
    width: 40px; /* w-10 */
    height: 40px; /* h-10 */
    background-color: #2D3748; /* Darker gray background for icons */
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    margin-right: 1rem; /* space-x-4 equivalent */
}

    </style>
    @yield('styles') {{-- Allows child views to add specific styles --}}
</head>
<body class="text-gray-800">
    {{-- Header --}}
    @include('components.newsDashboardHeader')
    {{-- Stock Ticker --}}
 





    {{-- Main Content Area --}}
    <main class="">
        @yield('content') {{-- This is where the content from the child view will be injected --}}
    </main>


@include('components.newfooter')
    <script src="{{ asset('assets/js/BasilTradeJs/js/news.js') }}"></script>
    @yield('scripts') {{-- Allows child views to add specific scripts --}}
</body>
</html>