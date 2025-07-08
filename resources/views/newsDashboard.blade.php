@extends('layouts.newsDashboardLayout')

@section('title', 'Financial News Dashboard')

@section('content')
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

    <style>
    main{
        display:  block !important;
        max-width: 100% !important;
    }
        .footer-bg {
            background-color: #1F3F3E;
        }
        /* Email input specific styles */
        .footer-email-input {
            background-color: #ffffff;
            color: #1a202c;
            padding: 0.75rem 1rem;
            border-radius: 0.375rem;
            border: none;
            width: 100%;
        }
        .footer-email-input::placeholder {
            color: #4A5568;
        }
        .footer-email-input:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.5);
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
            color: #A0AEC0;
            transition: color 0.3s ease;
        }
        .footer-link:hover {
            color: #4CAF50;
        }
        /* Contact info icon circle */
        .contact-icon-circle {
            width: 40px;
            height: 40px;
            background-color: #2D3748;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-right: 1rem;
        }
        .section-bg-light-gray {
            background-color: #F8FFA3;
            color: #1a202c;
        }

        /* Style for FAQ item header */
        .faq-item-header {
            background-color: #F8F9FA;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .faq-item-header:hover {
            background-color: #EFEFEF;
        }
        /* Style for FAQ content */
        .faq-item-content {
            background-color: #FFFFFF;
            border-top: 1px solid #E2E8F0;
        }
        .carbon-footprint-box-bg {
            background: linear-gradient(to right, #4CAF50, #8BC34A);
        }

        .section-bg-light-gray {
            background-color: #F8F9FA;
            color: #1a202c;
        }
        /* Custom gradient for the "More Project" button */
        .more-project-btn {
            background: linear-gradient(to right, #4CAF50, #8BC34A);
            transition: opacity 0.3s ease;
        }
        .more-project-btn:hover {
            opacity: 0.9;
        }
        /* Overlay for project cards with images */
        .project-card-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.8), rgba(0,0,0,0));
            padding: 1.5rem;
            padding-top: 5rem;
            color: white;
            text-align: left;
            border-bottom-left-radius: 0.5rem;
            border-bottom-right-radius: 0.5rem;
        }
        /* Background for the "Solar-Powered Retail Mall" card */
        .retail-mall-card-bg {
            background: linear-gradient(to right, #8BC34A, #4CAF50);
        }
        /* For the circular client images */
        .client-img {
            border: 2px solid #4CAF50;
        }

        .section-bg-light-gray {
            background-color: #F8F9FA;
            color: #1a202c;
        }
        /* Custom styles for the "About Us" button, if a specific green gradient is needed */
        .about-us-btn {
            background: linear-gradient(to right, #4CAF50, #8BC34A);
            transition: opacity 0.3s ease;
        }
        .about-us-btn:hover {
            opacity: 0.9;
        }
        /* Card backgrounds */
        .mission-card-bg {
            background-color: #2D3748;
        }
        .vision-card-bg {
            background: linear-gradient(to right, #8BC34A, #4CAF50);
        }

        .smart-energy-card-bg {
            background: linear-gradient(to right, #8BC34A, #4CAF50);
        }
        /* Subtle dark background for the first two cards */
        .feature-card-dark-bg {
            background-color: #2D3748;
        }
        /* Custom styles for the background image and overlay */
        .hero-banner {
            background-image: url('https://basilstar.com/assets/img/hero_banner.jpeg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
            padding-bottom: 8rem;
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }

        /* Adjusting font for closer match - Montserrat seems plausible */
        body {
            background-color: #1a202c;
        }

        /* Custom style for the play button circle and triangle */
        .play-button-circle {
            width: 60px;
            height: 60px;
            background-color: rgba(76, 175, 80, 0.8);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .play-button-circle:hover {
            background-color: rgba(76, 175, 80, 1);
        }
        .play-button-triangle {
            width: 0;
            height: 0;
            border-top: 15px solid transparent;
            border-bottom: 15px solid transparent;
            border-left: 20px solid white;
            margin-left: 5px;
        }

        /* Specific gradient for the bottom info bar in the hero section */
        .info-bar-gradient {
             background: linear-gradient(to right, #2d3748, #4a5568);
        }

        /* Adjust navigation height */
        .nav-height {
            height: 80px;
        }

        .service-card-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.8), rgba(0,0,0,0));
            padding: 1.5rem;
            padding-top: 5rem;
            color: white;
            text-align: left;
            border-bottom-left-radius: 0.5rem;
            border-bottom-right-radius: 0.5rem;
        }

        /* Specific card background color (if not a pure black) */
        .service-card-main-bg {
            background-color: #2D3748;
        }

        .section-bg-light-gray {
            background-color: #F8F9FA;
            color: #1a202c;
        }
        /* Custom style for the star ratings */
        .star-rating svg {
            color: #4CAF50;
        }
        /* Custom styles for the quote icon */
        .quote-icon {
            font-size: 3rem;
            line-height: 1;
            color: #4CAF50;
            margin-right: 0.5rem;
        }
        /* Client avatar image style */
        .client-avatar {
            border: 2px solid #4CAF50;
        }

        .form-input-dark {
            background-color: #2D3748;
            border: 1px solid #4A5568;
            color: white;
            padding: 0.75rem 1rem;
            border-radius: 0.375rem;
            width: 100%;
        }
        .form-input-dark::placeholder {
            color: #A0AEC0;
        }
        .form-input-dark:focus {
            outline: none;
            border-color: #4CAF50;
            box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.5);
        }
        /* Custom gradient for the submit button */
        .submit-btn-gradient {
            background: linear-gradient(to right, #4CAF50, #8BC34A);
            transition: opacity 0.3s ease;
        }
        .submit-btn-gradient:hover {
            opacity: 0.9;
        }
        .social-icon-circle {
            width: 44px;
            height: 44px;
            background-color: #2D3748;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.3s ease;
        }
        .social-icon-circle:hover {
            background-color: #4CAF50;
        }
        
        .swiper-button-next,
        .swiper-button-prev {
            color: #4CAF50 !important;
            top: unset !important;
            bottom: -50px;
            transform: translateY(0) !important;
        }
        .swiper-button-prev {
            left: 0;
            right: unset;
        }
        .swiper-button-next {
            right: 0;
            left: unset;
        }
        /* Custom styles for the navigation buttons to match theme */
        .custom-nav-btn {
            background-color: #2D3748;
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 9999px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .custom-nav-btn:hover {
            background-color: #4CAF50;
        }
   .swiper-button-next,
        .swiper-button-prev {
            color: #4CAF50 !important;
            top: unset !important;
            bottom: -50px;
            transform: translateY(0) !important;
        }
        .swiper-button-prev {
            left: 0;
            right: unset;
        }
        .swiper-button-next {
            right: 0;
            left: unset;
        }
        .custom-nav-btn {
            background-color: #2D3748;
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 9999px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .custom-nav-btn:hover {
            background-color: #4CAF50;
        }
        .swiper-pagination {
            position: relative !important;
            bottom: -30px !important;
            left: 0 !important;
            width: 100% !important;
            display: flex;
            justify-content: center;
        }
        .swiper-pagination-bullet {
            background: #A0AEC0 !important;
            opacity: 0.6 !important;
            margin: 0 4px !important;
            width: 10px !important;
            height: 10px !important;
        }
        .swiper-pagination-bullet-active {
            background: #4CAF50 !important;
            opacity: 1 !important;
            width: 12px !important;
            height: 12px !important;
        }

        /* Styles for the news cards */
        .economy-news-card {
            background-color: #2D3748;
            border-radius: 0.5rem;
            overflow: hidden;
            position: relative;
            cursor: pointer;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .economy-news-card-image {
            width: 100%;
            height: 15rem;
            object-fit: cover;
            transition: transform 0.3s ease-in-out;
        }
        .economy-news-card:hover .economy-news-card-image {
            transform: scale(1.05);
        }
        .economy-news-card-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.9), rgba(0, 0, 0, 0.4) 50%, rgba(0, 0, 0, 0) 100%);
            padding: 1.5rem;
            padding-top: 5rem;
            color: white;
            text-align: left;
            border-bottom-left-radius: 0.5rem;
            border-bottom-right-radius: 0.5rem;
        }
        .economy-news-card-title {
            font-weight: bold;
            font-size: 1.25rem;
            line-height: 1.75rem;
            margin-bottom: 0.5rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .economy-news-card-snippet {
            color: #CBD5E0;
            font-size: 0.875rem;
            line-height: 1.5;
            margin-bottom: 1rem;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .economy-news-card-link {
            display: inline-flex;
            align-items: center;
            color: #4CAF50;
            font-size: 0.875rem;
            font-weight: 600;
            margin-top: 0.5rem;
            transition: color 0.3s ease;
        }
        .economy-news-card-link:hover {
            color: #8BC34A;
        }
        
        #startups-news-container a {
        color: #8b9c92 !important;
        }
        
        #startups-news-container p {
            color: #005550; 
        }
        
       .startups-title {
    color: #005550;
  }
    </style>
    <div class="hero-banner relative">
        <div class="hero-overlay"></div>


        <div class="relative z-10 px-4 max-w-4xl mx-auto flex flex-col items-center justify-center pt-20 pb-20">
            <div class="mb-8">
                <!--<div class="play-button-circle">-->
                <!--    <div class="play-button-triangle"></div>-->
                <!--</div>-->
            </div>

            <h1 class="text-5xl md:text-6xl lg:text-7xl font-extrabold leading-tight mb-4 drop-shadow-lg">
                Welcome to <br> <span class="text-[#52fcb1]">BasilStar</span>
            </h1>
            <p class="text-lg md:text-xl text-gray-200 mb-8 max-w-2xl">
               Your AI-powered partner for smart investing.
            </p>
            
           <a href="/about">
    <button class="bg-[#51fcb1] hover:bg-[#45e0a0] text-[#0f443f] font-bold py-3 px-8 rounded-full text-lg shadow-lg transition duration-300">
    Learn More
</button>

</a>
        </div>
    </div>

    <section class="py-16 px-4 bg-[#005550] text-center">
        <div class="max-w-8xl mx-auto">
            <div class="text-left mb-12">
                <p class="text-white text-lg font-semibold mb-2">Latest News Updates </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
   <div class="p-4 rounded-lg shadow-xl text-left bg-[#005550] border border-[#52fcb1] space-y-4">
    <div class="flex justify-between items-center">
        <h1 class="text-white font-bold text-xl">All News</h1>
    </div>
    <div id="all-news-container" class="space-y-4">
        <!-- Dynamic All News Content will be loaded here -->
        <p class="text-gray-300">Loading all news...</p>
    </div>
</div>


                <div class="p-4 rounded-lg shadow-xl text-left bg-[#005550] border border-[#52fcb1] flex flex-col">

                    <div class="flex justify-between items-center">
                        <h1 class="text-white font-bold text-xl">PREDICTION & ANALYSIS</h1>
                    </div>
                    <div id="prediction-analysis-news-container" class="space-y-4">
                        <!-- Dynamic Prediction & Analysis News Content will be loaded here -->
                        <p class="text-gray-300">Loading prediction & analysis news...</p>
                    </div>
                    
                </div>

                <div class="p-4 rounded-lg shadow-xl text-left bg-[#005550] border border-[#52fcb1] flex flex-col">
                    <h3 class="text-2xl font-bold text-white mb-3">MARKET OVERVIEW</h3>
                    <div class="bg-white rounded-md p-6 shadow-md text-gray-800">
                        <h2 class="text-xl font-semibold text-green-700 mb-2">
                            Market Prediction for Next Trading Session
                        </h2>
                        <p class="text-sm text-gray-600 mb-4 italic">
                            Explore on Basil Star
                        </p>
                        <p class="text-base leading-relaxed">
                            Global cues remain mixed. Domestic market sentiment is positive due to strong economic data. Expect consolidation with potential for a late-day rally.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <section class="py-16 px-4 bg-[#e4f9e1]">
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-10 items-center">

        <!-- Text Content -->
        <div>
            <p class="text-primary font-bold mb-2">Who We Are</p>
            <h2 class="text-4xl lg:text-5xl font-extrabold text-gray-900 leading-tight mb-6">
                Smarter Trading with Basil Star
            </h2>
            <p class="text-gray-700 mb-4 text-lg">
                <strong>Basil Star</strong> is your go-to trading platform for smarter, more confident investing. We
                bring you AI-powered insights, strategic investment tools, and expert market analysis to help you make
                informed decisions.
            </p>
            <p class="text-gray-700 mb-4 text-lg">
                From intraday signals to in-depth stock analysis and comprehensive portfolio management, we empower
                every investor. With advanced features like our AI-driven stock analyzer, instant auto-basket strategy
                builder, and real-time market updates, we simplify investing so you can focus on growth.
            </p>
            <h3 class="text-2xl font-semibold text-primary mt-8 mb-3">Our Story</h3>
            <p class="text-gray-700 text-lg">
                Basil Star was founded on a simple idea: make trading intelligent and effortless. Our platform
                seamlessly blends cutting-edge AI analytics with expert market research, delivering real-time insights,
                robust risk management, and winning investment strategies. By combining the power of technology with
                proven strategy, we help investors build wealth with confidence.
            </p>
        </div>

        <!-- Image Content -->
        <div>
            <img src="https://hedge.guide/wp-content/uploads/2020/10/shutterstock_1612684897-768x512.jpg" alt="Smart Trading"
                class="rounded-3xl w-full object-cover shadow-lg">
        </div>

    </div>
</section>
      
    <section class="bg-[#005550] py-16 lg:py-24 px-4">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-center mb-12 md:mb-16 text-left">
            <div class="mb-6 md:mb-0">
                <p class="text-green-400 text-lg font-semibold mb-2">ECONOMY NEWS</p>
                <h2 class="text-4xl md:text-5xl font-extrabold leading-tight text-white">
                    Emerging <span class="text-green-400">Markets Boost</span> Growth and Economic Stability 
                    
             
                </h2>
            </div>
            <p class="text-gray-300 text-base md:text-lg max-w-lg">
                Stay updated with the latest trends and insights that drive global financial markets, analyze market shifts, and identify key investment opportunities.
            </p>
        </div>

        <div class="relative pb-10">
            <div class="swiper-container economy-news-slider">
                <div class="swiper-wrapper" id="economy-news-container" style="overflow: hidden;">
                    <!-- Dynamic Economy News Content will be loaded here -->
                    <p class="text-gray-300 swiper-slide">Loading economy news...</p>
                </div>
                <div class="swiper-pagination swiper-pagination-economy-news"></div>
            </div>
            <div class="mt-8 space-x-4 flex justify-center w-full absolute bottom-0 left-0 right-0">
                 
                 
            </div>
        </div>
    </div>
</section>
      
    <section class="py-16 px-4 bg-[#e4f9e1] text-center">
        <div class="max-w-7xl mx-auto">
            <div class="text-left mb-12">
                <p class="text-green-400 text-lg font-semibold mb-2">Innovators' Digest</p>
                <h4 class="text-4xl lg:text-5xl font-extrabold text-gray-900 leading-tight mb-6">
                    Latest updates from the world of <span class="text-green-400">Technology</span> and <br
                        class="hidden md:inline"> Emerging <span class="text-green-400">Startups</span>
                </h4>
            </div>
    
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
    
                <div
                    class="p-4 rounded-lg shadow-xl text-left bg-[#005550]  flex flex-col ">
                    <h1 class="text-white font-bold text-xl mb-4">TECHNOLOGY NEWS</h1>
                    <div id="technology-news-container" class="space-y-4">
                        <!-- Dynamic Technology News Content will be loaded here -->
                        <p class="text-gray-300">Loading technology news...</p>
                    </div>
                </div>
    
                <div
                    class="p-4 rounded-lg shadow-xl text-left bg-[#51fcb1] border border-[#99f36b] flex flex-col border border-[#99f36b]">
                    <h1 class="text-xl font-semibold mb-3">STARTUPS NEWS</h1>
                    <div id="startups-news-container" class="space-y-4">
                        <!-- Dynamic Startups News Content will be loaded here -->
                        <p class="text-gray-300">Loading startups news...</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
      

<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const allNewsContainer = document.getElementById('all-news-container');
            const predictionAnalysisContainer = document.getElementById('prediction-analysis-news-container');
            const technologyNewsContainer = document.getElementById('technology-news-container');
            const startupsNewsContainer = document.getElementById('startups-news-container');
            const economyNewsContainer = document.getElementById('economy-news-container');

            // Helper function to strip HTML tags
            function stripHtml(html) {
                let doc = new DOMParser().parseFromString(html, 'text/html');
                return doc.body.textContent || "";
            }

            // Function to render news in the list format (for All News, Prediction, Tech, Startups)
            function renderNewsList(container, articles, keywords = []) {
                container.innerHTML = ''; // Clear existing content

                let filteredArticles = articles;
                if (keywords.length > 0) {
                    const lowerCaseKeywords = keywords.map(k => k.toLowerCase());
                    filteredArticles = articles.filter(article => {
                        const title = (article.title || '').toLowerCase();
                        const text = (article.text || article.content || '').toLowerCase();
                        return lowerCaseKeywords.some(keyword => title.includes(keyword) || text.includes(keyword));
                    });
                }

                if (filteredArticles.length === 0) {
                    container.innerHTML = '<p class="text-gray-300">No news available at the moment for this category.</p>';
                    return;
                }

                filteredArticles.slice(0, 4).forEach(article => {
                    const newsItem = document.createElement('div');
                    newsItem.className = 'flex items-start space-x-3';

                    // Determine image URL based on API response structure
                    const imageUrl = article.image || 'https://placehold.co/100x80/e2e8f0/000?text=No+Image';

                    // Determine snippet based on API response structure
                    const snippet = article.text || article.content;
                    const displaySnippet = snippet
                        ? (stripHtml(snippet).length > 70 ? stripHtml(snippet).slice(0, 70) + '...' : stripHtml(snippet))
                        : 'No snippet available.';

                    // Create a link to the detail page with article ID or title as parameter
                    const detailUrl = `/news/${encodeURIComponent(article.symbol || article.title || article.id)}`;

                    newsItem.innerHTML = `
                        <a href="${detailUrl}" class="flex items-start space-x-3 w-full">
                            <img src="${imageUrl}" alt="News Image" class="w-10 h-10 rounded-sm object-cover flex-shrink-0" onerror="this.onerror=null; this.src='https://placehold.co/100x80/e2e8f0/000?text=No+Image'">
                            <div class="text-sm text-white leading-tight flex-grow min-w-0">
                                <p class="font-semibold truncate">${article.title || 'No Title'}</p>
                                <p class="text-gray-300 text-xs truncate">${displaySnippet}</p>
                                <span class="text-green-400 hover:text-green-500 text-xs mt-1 inline-flex items-center">
                                    Read More
                                    <svg class="h-3 w-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                    </svg>
                                </span>
                            </div>
                        </a>
                    `;
                    container.appendChild(newsItem);
                });
            }

            // Function to render news in the card format for Economy News slider
            function renderEconomyNewsCards(container, articles) {
                container.innerHTML = '';
                if (articles.length === 0) {
                    container.innerHTML = '<div class="swiper-slide"><p class="text-gray-300">No economy news available at the moment.</p></div>';
                    return;
                }

                articles.forEach(article => {
                    const newsCard = document.createElement('div');
                    newsCard.className = 'swiper-slide economy-news-card group';

                    const imageUrl = article.image || 'https://placehold.co/600x400/2D3748/A0AEC0?text=No+Image';
                    const title = article.title || 'No Title Available';
                    const snippet = stripHtml(article.content) || 'No snippet available.';

                    // Create a link to the detail page with article ID or title as parameter
                    const detailUrl = `/news/${encodeURIComponent(article.symbol || article.title || article.id)}`;

                    newsCard.innerHTML = `
                        <a href="${detailUrl}">
                            <img src="${imageUrl}" alt="${title}" class="economy-news-card-image" onerror="this.onerror=null; this.src='https://placehold.co/600x400/2D3748/A0AEC0?text=No+Image'">
                            <div class="economy-news-card-overlay">
                                <h3 class="economy-news-card-title">${title}</h3>
                                <p class="economy-news-card-snippet">${snippet.length > 150 ? snippet.slice(0, 150) + '...' : snippet}</p>
                                <span class="economy-news-card-link">
                                    Read More
                                    <svg class="h-4 w-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                </span>
                            </div>
                        </a>
                    `;
                    container.appendChild(newsCard);
                });
            }

            // Function to fetch and load news for the "All News" section
            async function loadAllNews() {
                const API_URL = 'https://financialmodelingprep.com/api/v4/general_news?page=0&apikey=T8HogSezq0WNy97WinOjjLMEOuiKjnu5';
                try {
                    const response = await fetch(API_URL);
                    if (!response.ok) {
                        const errorText = await response.text();
                        console.error(`HTTP error! Status: ${response.status}. Response: ${errorText}`);
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    const data = await response.json();
                    renderNewsList(allNewsContainer, data);
                } catch (error) {
                    console.error('Error fetching all news:', error);
                    allNewsContainer.innerHTML = '<p class="text-gray-300">Failed to load news. Please try again later.</p>';
                }
            }

            // Function to fetch and load news for the "Prediction & Analysis" section
            async function loadPredictionAnalysisNews() {
                const API_URL = 'https://financialmodelingprep.com/api/v3/stock_news?&apikey=T8HogSezq0WNy97WinOjjLMEOuiKjnu5';
                try {
                    const response = await fetch(API_URL);
                    if (!response.ok) {
                        const errorText = await response.text();
                        console.error(`HTTP error! Status: ${response.status}. Response: ${errorText}`);
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    const data = await response.json();
                    renderNewsList(predictionAnalysisContainer, data);
                } catch (error) {
                    console.error('Error fetching prediction & analysis news:', error);
                    predictionAnalysisContainer.innerHTML = '<p class="text-gray-300">Failed to load prediction & analysis news. Please try again later.</p>';
                }
            }

            // Function to fetch and load news for the "Technology News" and "Startups News" sections
            async function loadFilteredNewsCategories() {
                const API_URL_GENERAL = 'https://financialmodelingprep.com/api/v4/general_news?page=0&apikey=T8HogSezq0WNy97WinOjjLMEOuiKjnu5';
                const API_URL_STOCK = 'https://financialmodelingprep.com/api/v3/stock_news?&apikey=T8HogSezq0WNy97WinOjjLMEOuiKjnu5';
                const API_URL_SENTIMENTS = 'https://financialmodelingprep.com/api/v4/stock-news-sentiments-rss-feed?page=0&apikey=T8HogSezq0WNy97WinOjjLMEOuiKjnu5';

                try {
                    const [generalNewsResponse, stockNewsResponse, sentimentsNewsResponse] = await Promise.all([
                        fetch(API_URL_GENERAL),
                        fetch(API_URL_STOCK),
                        fetch(API_URL_SENTIMENTS)
                    ]);

                    const generalNews = generalNewsResponse.ok ? await generalNewsResponse.json() : [];
                    const stockNews = stockNewsResponse.ok ? await stockNewsResponse.json() : [];
                    const sentimentsNews = sentimentsNewsResponse.ok ? await sentimentsNewsResponse.json() : [];

                    // Combine all fetched news into a single array
                    const combinedNews = [...generalNews, ...stockNews, ...sentimentsNews];

                    // Sort combined news by publishedDate/date in descending order to get the latest
                    combinedNews.sort((a, b) => {
                        const dateA = new Date(a.publishedDate || a.date);
                        const dateB = new Date(b.publishedDate || b.date);
                        return dateB - dateA;
                    });

                    // Keywords for Technology News
                    const techKeywords = ['tech', 'technology', 'software', 'AI', 'artificial intelligence', 'quantum', 'cybersecurity', 'innovation', 'digital', 'hardware', 'semiconductor', 'gadget', 'internet', 'cloud', 'robotics', 'microsoft', 'apple', 'google', 'amazon', 'nvidia', 'intel', 'facebook', 'tech'];
                    renderNewsList(technologyNewsContainer, combinedNews, techKeywords);

                    // Keywords for Startups News
                    const startupKeywords = ['startup', 'funding', 'venture', 'seed round', 'series A', 'incubator', 'accelerator', 'new company', 'emerging business', 'fintech', 'edtech', 'healthtech', 'biotech', 'proptech', 'unicorns', 'investment', 'launch', 'innovation'];
                    renderNewsList(startupsNewsContainer, combinedNews, startupKeywords);

                } catch (error) {
                    console.error('Error fetching and filtering technology and startups news:', error);
                    technologyNewsContainer.innerHTML = '<p class="text-gray-300">Failed to load technology news. Please try again later.</p>';
                    startupsNewsContainer.innerHTML = '<p class="text-gray-300">Failed to load startups news. Please try again later.</p>';
                }
            }

            let economySwiper = null;

            async function loadEconomyNews() {
                const API_URL = 'https://financialmodelingprep.com/api/v3/fmp/articles?page=0&size=5&apikey=T8HogSezq0WNy97WinOjjLMEOuiKjnu5';
                try {
                    const response = await fetch(API_URL);
                    if (!response.ok) {
                        const errorText = await response.text();
                        console.error(`HTTP error! Status: ${response.status}. Response: ${errorText}`);
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    const data = await response.json();
                    renderEconomyNewsCards(economyNewsContainer, data.content);

                    if (economySwiper) {
                        economySwiper.destroy(true, true);
                    }

                    if (data.content && data.content.length > 0) {
                        economySwiper = new Swiper('.economy-news-slider', {
                            slidesPerView: 1,
                            spaceBetween: 30,
                            loop: true,
                            autoplay: {
                                delay: 5000,
                                disableOnInteraction: false,
                                pauseOnMouseEnter: true,
                            },
                            pagination: {
                                el: '.swiper-pagination-economy-news',
                                clickable: true,
                            },
                            navigation: {
                                nextEl: '.swiper-button-next-economy-news',
                                prevEl: '.swiper-button-prev-economy-news',
                            },
                            breakpoints: {
                                768: {
                                    slidesPerView: 2,
                                },
                                1024: {
                                    slidesPerView: 2,
                                }
                            }
                        });
                    }
                } catch (error) {
                    console.error('Error fetching economy news:', error);
                    economyNewsContainer.innerHTML = '<div class="swiper-slide"><p class="text-gray-300">Failed to load economy news. Please try again later.</p></div>';
                }
            }

            // Call the functions to load news when the DOM is ready
            loadAllNews();
            loadPredictionAnalysisNews();
            loadFilteredNewsCategories();
            loadEconomyNews();
        });
    </script>

@endsection