@extends('layouts.newsDashboardLayout')

@section('title', 'Financial News Dashboard')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All News - Your Site</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/BasilFav.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Custom styles for layout sections */
        body {
            font-family: 'Inter', sans-serif;
        }
        .top-news-section {
            display: flex;
            flex-direction: column; /* Stack columns on small screens */
            gap: 2rem; /* Gap between columns */
        }
        .container {
            flex-direction: column !important;
        }

        @media (min-width: 768px) { /* md breakpoint */
            .top-news-section {
                flex-direction: row; /* Side-by-side columns on medium and larger screens */
            }
        }

        .featured-news {
            flex: 2; /* Take more space in the row layout */
        }

        .latest-news-sidebar {
            flex: 1; /* Take less space in the row layout */
        }

        /* Styling for the featured news card */
        .featured-card {
            background-color: #fff;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: box-shadow 200ms ease-in-out;
            cursor: pointer;
            display: flex;
            flex-direction: column; /* Stack image and text vertically */
        }
         .featured-card:hover {
             box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
         }
         .featured-card h3 {
            font-weight: 700; /* font-bold */
            color: #1f2937; /* text-gray-900 */
            font-size: 1.25rem; /* text-xl */
            margin-bottom: 0.5rem;
        }
         .featured-card p {
             font-size: 0.875rem; /* text-sm */
             color: #6b7280; /* text-gray-500 */
             margin-top: 0.25rem;
         }
         .featured-card .para {
             color: #374151; /* text-gray-700 */
             margin-top: 0.75rem;
             line-height: 1.5;
         }

        /* Styling for the latest news list items */
        .latest-news-item {
            display: flex;
            align-items: center;
            gap: 1rem; /* Space between image and text */
            padding: 0.75rem 0; /* Padding for list items */
            border-bottom: 1px solid #e5e7eb; /* Divider */
            cursor: pointer;
            transition: background-color 150ms ease-in-out;
        }
        .latest-news-item:last-child {
            border-bottom: none; /* No border on the last item */
        }
         .latest-news-item:hover {
             background-color: #f9fafb; /* hover:bg-gray-50 */
         }

        .latest-news-item img {
            width: 80px; /* Smaller image for list items */
            height: 60px;
            object-fit: cover;
            border-radius: 0.25rem; /* rounded */
             flex-shrink: 0; /* Prevent image from shrinking */
        }

        .latest-news-item .content {
            flex-grow: 1; /* Allow content to take available space */
        }

        .latest-news-item h4 {
            font-weight: 600; /* font-semibold */
            color: #1f2937; /* text-gray-900 */
            font-size: 0.875rem; /* text-sm */
            line-height: 1.4;
        }
         .latest-news-item p {
             font-size: 0.75rem; /* text-xs */
             color: #6b7280; /* text-gray-500 */
             margin-top: 0.25rem;
         }


        /* Styling for the main news grid */
        .news-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); /* Responsive grid */
            gap: 1.5rem; /* Gap between grid items */
            margin-top: 2rem; /* Space above the grid */
        }

        .news-item-card { /* Reuse the card style for grid items */
            display: flex;
            flex-direction: column;
            overflow: hidden;
            background-color: #fff;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: box-shadow 200ms ease-in-out;
            cursor: pointer;
        }
         .news-item-card:hover {
             box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
         }

        .news-item-card img {
            width: 100%;
            height: 180px; /* Slightly smaller image for grid items */
            object-fit: cover;
        }

         .news-item-card .content {
            padding: 1rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
         }

         .news-item-card h3 {
            font-weight: 600; /* font-semibold */
            color: #1f2937; /* text-gray-900 */
            font-size: 1rem; /* text-base */
            margin-bottom: 0.5rem;
         }

         .news-item-card p {
            font-size: 0.875rem; /* text-sm */
            color: #6b7280; /* text-gray-500 */
         }

         .news-item-card .para {
            color: #374151; /* text-gray-700 */
            margin-top: 0.5rem;
            line-height: 1.4;
         }

         .news-item-card .read-more {
            display: inline-block;
            margin-top: 0.5rem;
            color: #3b82f6; /* text-blue-600 */
         }
         .news-item-card .read-more:hover {
            text-decoration: underline;
         }


        /* Styles for loading, error, and no news messages */
         .loading-message, .error-message, .no-news-message {
             text-align: center;
             color: #6b7280; /* text-gray-600 */
             margin-top: 2rem;
             width: 100%; /* Ensure it spans the grid */
             grid-column: 1 / -1; /* Span all columns in the grid */
         }
         .error-message {
             color: #dc2626; /* text-red-600 */
         }

         /* Heading for various news sections */
         .news-section-heading {
             font-size: 1.5rem; /* text-2xl */
             font-weight: 700; /* font-bold */
             color: #1f2937; /* text-gray-900 */
             margin-bottom: 1.5rem;
             padding-bottom: 0.5rem;
             border-bottom: 3px solid #3b82f6; /* Blue underline */
             text-align: center;
             margin-top: 2rem;
         }
         @media (min-width: 768px) {
            .news-section-heading {
                text-align: left;
            }
         }


        /* Stock Ticker Styles */
        .stock-ticker-container {
            background-color: #1f2937; /* Dark background */
            padding: 0.5rem 0;
            overflow: hidden; /* Hide overflowing content for the scroll effect */
            white-space: nowrap; /* Keep items on a single line */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            color: #ffffff; /* White text for contrast */
            position: relative;
        }

        .stock-ticker-content {
            display: inline-block; /* Allows items to flow horizontally */
            animation: scroll 30s linear infinite; /* Apply the scrolling animation */
        }

        .scroll-item {
            display: inline-block;
            margin-right: 2rem; /* Space between stock items */
            font-family: 'Inter', sans-serif;
        }

        @keyframes scroll {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); } /* Scroll half the content width */
        }
    </style>
</head>
<body class="bg-gray-100 font-sans">

    {{-- Stock Ticker --}}
    <div class="stock-ticker-container">
        <div id="stock-ticker-content" class="stock-ticker-content">
            {{-- Stock data will be loaded here by JavaScript --}}
        </div>
    </div>

    <header class="bg-white shadow">
        <div class="container mx-auto px-6 py-4 rounded-b-lg stye" style="padding-top: 100px !important;">

           <h1 class="text-base sm:text-lg md:text-3xl font-semibold sm:font-bold md:font-extrabold text-gray-800 text-left whitespace-nowrap">
  Global News Dashboard
</h1>

        </div>
    </header>

    <main class="container mx-auto px-6 py-8">

        {{-- Featured and Latest News Section --}}
        <div class="top-news-section mb-12">
            <div id="featured-news-container" class="featured-news bg-white p-4 rounded-lg shadow-md">
                 <h2 class="news-section-heading !text-left !mt-0 !mb-4 !border-b-2">Featured Story</h2>
                 <p class="loading-message">Loading featured news...</p>
            </div>

            <div class="latest-news-sidebar bg-white p-4 rounded-lg shadow-md">
                <h2 class="news-section-heading !text-left !mt-0 !mb-4 !border-b-2">Latest Updates</h2>
                <div id="latest-news-list">
                     <p class="loading-message">Loading latest news...</p>
                </div>
            </div>
        </div>

        {{-- General News Section --}}
        <h2 class="news-section-heading">General News</h2>
        <div id="general-news-container" class="news-grid">
            <p class="loading-message col-span-full">Loading general news...</p>
        </div>

        {{-- India News Section --}}
        <h2 class="news-section-heading">India News</h2>
        <div id="india-news-container" class="news-grid">
            <p class="loading-message col-span-full">Loading India news...</p>
        </div>

        {{-- Stock Sentiments News Section --}}
        <h2 class="news-section-heading">Stock Market Sentiments</h2>
        <div id="stock-sentiments-container" class="news-grid">
            <p class="loading-message col-span-full">Loading stock sentiments...</p>
        </div>

    </main>

    <script>
        // API Keys - Replace with your actual keys
        const FMP_API_KEY = 'T8HogSezq0WNy97WinOjjLMEOuiKjnu5'; // Your Financial Modeling Prep API key
        const TWELVE_DATA_API_KEY = "e2fb0acfee10401da4f7151094e4e6b2"; // Your Twelve Data API Key
        // You might need an additional API for specific India news if FMP doesn't provide enough granularity.
        // For demonstration, we'll try to filter FMP General News for 'India'.

        // API Endpoints
        const FMP_ARTICLES_URL = 'https://financialmodelingprep.com/api/v3/fmp/articles';
        const GENERAL_NEWS_URL = 'https://financialmodelingprep.com/api/v4/general_news';
        const STOCK_SENTIMENTS_URL = 'https://financialmodelingprep.com/api/v4/stock-news-sentiments-rss-feed';

        // Get references to the specific containers
        const featuredNewsContainer = document.getElementById('featured-news-container');
        const latestNewsList = document.getElementById('latest-news-list');
        const generalNewsContainer = document.getElementById('general-news-container');
        const indiaNewsContainer = document.getElementById('india-news-container');
        const stockSentimentsContainer = document.getElementById('stock-sentiments-container');
        const stockTickerContent = document.getElementById('stock-ticker-content');

        // Define how many articles go into each section
        const FEATURED_NEWS_COUNT = 1;
        const LATEST_NEWS_COUNT = 8;
        const GENERAL_NEWS_GRID_COUNT = 12; // For the main general news grid
        const INDIA_NEWS_GRID_COUNT = 8; // For the India specific news grid
        const STOCK_SENTIMENTS_GRID_COUNT = 8; // For stock sentiments grid

        /**
         * Fetches news from a given API endpoint.
         * @param {string} url - The API endpoint URL.
         * @param {number} page - The page number for pagination.
         * @param {number} size - The number of items per page.
         * @param {string} query - Optional query parameter for filtering (e.g., 'India').
         * @returns {Promise<Array>} A promise that resolves to an array of articles.
         */
        async function fetchNews(url, page = 0, size = 5, query = '') {
            try {
                let apiUrl = `${url}?page=${page}&size=${size}&apikey=${FMP_API_KEY}`;
                if (query) {
                    // Note: FMP's general_news API doesn't have a direct 'country' filter.
                    // We'll rely on post-fetch filtering or keyword search if available.
                    // For now, if 'query' is used, it implies a keyword search for some APIs.
                    // FMP general_news API might not support 'q' parameter directly for filtering by keyword.
                    // We'll fetch and then filter client-side if needed.
                }

                const response = await fetch(apiUrl);
                if (!response.ok) {
                    const errorText = await response.text();
                    console.error(`Error fetching news from ${url}:`, response.status, errorText);
                    throw new Error(`Error fetching news: ${response.status}`);
                }
                const data = await response.json();
                // FMP articles return an array directly, others might have a 'data' key or be nested.
                // Normalize the response to always return an array of articles.
                if (data && data.content) { // For FMP articles
                    return data.content;
                } else if (Array.isArray(data)) { // For general_news, stock-news-sentiments
                    return data;
                }
                return [];
            } catch (error) {
                console.error(`Network or parsing error for ${url}:`, error);
                return [];
            }
        }

        /**
         * Renders news articles into a specified container.
         * @param {Array} articles - An array of news article objects.
         * @param {HTMLElement} targetContainer - The DOM element to render articles into.
         * @param {string} type - Type of news ('featured', 'latest', 'grid') for specific rendering logic.
         */
        function renderNews(articles, targetContainer, type = 'grid') {
            targetContainer.innerHTML = ''; // Clear container for initial load

            if (articles.length === 0) {
                let message = 'No news found.';
                if (type === 'featured') message = 'No featured news found.';
                else if (type === 'latest') message = 'No latest news found.';
                else if (type === 'grid') message = 'No news found for this section.';

                targetContainer.innerHTML = `<p class="no-news-message ${type === 'grid' ? 'col-span-full' : ''}">${message}</p>`;
                return;
            }

            articles.forEach(article => {
                const newsItem = document.createElement('div');
                let imageUrl = '';
                let title = '';
                let publishedAt = '';
                let source = '';
                let content = '';
                let articleUrl = '';

                // Normalize article data based on API structure
                title = article.title || 'No Title';
                imageUrl = article.image || article.image_url || 'https://placehold.co/400x200/e2e8f0/000?text=No+Image';
                publishedAt = new Date(article.publishedDate || article.date || Date.now()).toLocaleDateString();
                source = article.site || article.source || 'N/A';
                content = (article.text || article.snippet || article.content || 'No detailed description available.').replace(/<[^>]*>?/gm, ''); // Remove HTML
                articleUrl = article.url || article.link || '#';

                // Ensure image URL is valid
                imageUrl = imageUrl.startsWith('http') ? imageUrl : 'https://placehold.co/400x200/e2e8f0/000?text=No+Image';

                // Specific rendering for each section
                if (type === 'featured') {
                    imageUrl = imageUrl.replace('400x200', '600x350'); // Larger image for featured
                    newsItem.classList.add('featured-card', 'rounded-lg', 'overflow-hidden', 'shadow-md', 'hover:shadow-lg');
                    newsItem.innerHTML = `
                        <img src="${imageUrl}" alt="Featured Article Image" class="w-full h-64 object-cover rounded-t-lg" onerror="this.onerror=null; this.src='https://placehold.co/600x350/e2e8f0/000?text=No+Image';">
                        <div class="p-6">
                            <h3 class="font-extrabold text-gray-900 text-2xl mb-2 leading-tight">${title}</h3>
                            <p class="text-gray-600 text-sm mb-3"><span class="font-medium">Source:</span> ${source} | <span class="font-medium">Published:</span> ${publishedAt}</p>
                            <p class="text-gray-700 text-base leading-relaxed mb-4 para">${content.substring(0, 250)}...</p>
                            <a href="${articleUrl}" target="_blank" class="text-blue-700 hover:text-blue-900 font-semibold text-base inline-flex items-center group">
                                Read more
                                <svg class="ml-2 w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            </a>
                        </div>
                    `;
                } else if (type === 'latest') {
                    imageUrl = imageUrl.replace('400x200', '80x60'); // Smaller image for latest list
                    newsItem.classList.add('latest-news-item', 'rounded-md', 'hover:bg-gray-50', 'transition-colors');
                    newsItem.innerHTML = `
                        <img src="${imageUrl}" alt="News Image" class="rounded w-20 h-16 object-cover flex-shrink-0" onerror="this.onerror=null; this.src='https://placehold.co/80x60/e2e8f0/000?text=News';">
                        <div class="flex-grow">
                            <h4 class="font-semibold text-gray-900 text-sm leading-snug mb-1">${title}</h4>
                            <p class="text-gray-500 text-xs">${publishedAt}</p>
                        </div>
                    `;
                } else { // 'grid' for general, India, and stock sentiments
                    newsItem.classList.add('news-item-card', 'rounded-lg', 'overflow-hidden', 'shadow-md', 'hover:shadow-lg');
                    newsItem.innerHTML = `
                        <img src="${imageUrl}" alt="Article Image" class="w-full h-48 object-cover rounded-t-lg" onerror="this.onerror=null; this.src='https://placehold.co/400x200/e2e8f0/000?text=No+Image';">
                        <div class="p-4 flex flex-col flex-grow">
                            <h3 class="font-semibold text-gray-900 text-lg mb-2 leading-tight">${title}</h3>
                            <p class="text-gray-600 text-sm mb-3"><span class="font-medium">Source:</span> ${source} | <span class="font-medium">Published:</span> ${publishedAt}</p>
                            <p class="text-gray-700 text-sm leading-normal mb-4 para">${content.substring(0, 150)}...</p>
                            <a href="${articleUrl}" target="_blank" class="text-blue-700 hover:text-blue-900 font-semibold text-sm mt-auto inline-flex items-center group">
                                Read more
                                <svg class="ml-1 w-3 h-3 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            </a>
                        </div>
                    `;
                }

                targetContainer.appendChild(newsItem);
            });
        }

        /**
         * Loads news for all sections of the dashboard.
         */
        async function loadAllNews() {
            // Display loading messages for all sections
            featuredNewsContainer.querySelector('.loading-message').style.display = 'block';
            latestNewsList.innerHTML = '<p class="loading-message">Loading latest news...</p>';
            generalNewsContainer.innerHTML = '<p class="loading-message col-span-full">Loading general news...</p>';
            indiaNewsContainer.innerHTML = '<p class="loading-message col-span-full">Loading India news...</p>';
            stockSentimentsContainer.innerHTML = '<p class="loading-message col-span-full">Loading stock sentiments...</p>';

            try {
                // 1. Fetch and render Featured News (from FMP Articles)
                const fmpArticles = await fetchNews(FMP_ARTICLES_URL, 0, FEATURED_NEWS_COUNT);
                if (fmpArticles && fmpArticles.length > 0) {
                    renderNews([fmpArticles[0]], featuredNewsContainer, 'featured');
                } else {
                    featuredNewsContainer.innerHTML = '<h2 class="news-section-heading !text-left !mt-0 !mb-4 !border-b-2">Featured Story</h2><p class="no-news-message">No featured news found.</p>';
                }

                // 2. Fetch and render Latest News (from General News)
                const generalNewsForLatest = await fetchNews(GENERAL_NEWS_URL, 0, LATEST_NEWS_COUNT);
                if (generalNewsForLatest && generalNewsForLatest.length > 0) {
                    renderNews(generalNewsForLatest.slice(0, LATEST_NEWS_COUNT), latestNewsList, 'latest');
                } else {
                    latestNewsList.innerHTML = '<p class="no-news-message">No latest news found.</p>';
                }

                // 3. Fetch and render General News Grid (from General News, excluding latest)
                const generalNewsForGrid = await fetchNews(GENERAL_NEWS_URL, 0, GENERAL_NEWS_GRID_COUNT + LATEST_NEWS_COUNT); // Fetch more to ensure enough for grid
                const filteredGeneralNews = generalNewsForGrid.slice(LATEST_NEWS_COUNT, LATEST_NEWS_COUNT + GENERAL_NEWS_GRID_COUNT);
                if (filteredGeneralNews && filteredGeneralNews.length > 0) {
                    renderNews(filteredGeneralNews, generalNewsContainer, 'grid');
                } else {
                    generalNewsContainer.innerHTML = '<p class="no-news-message col-span-full">No general news found.</p>';
                }

                // 4. Fetch and render India News (filtering General News or using a specific API if available)
                // FMP General News doesn't have a direct 'country' filter. We'll filter client-side by keywords in title/content.
                const allGeneralNewsForIndiaFilter = await fetchNews(GENERAL_NEWS_URL, 0, 100); // Increased fetch size to 100
                const indiaKeywords = [
  "india",
  "indian",
  "bharat",
  "hindustan",
  "desh",
  "nation",
  "mumbai",
  "delhi",
  "new delhi",
  "bengaluru",
  "bangalore",
  "chennai",
  "kolkata",
  "hyderabad",
  "ahmedabad",
  "pune",
  "gurgaon",
  "noida",
  "lucknow",
  "kanpur",
  "surat",
  "jaipur",
  "bhopal",
  "nagpur",
  "indore",
  "narendra modi",
  "rahul gandhi",
  "amit shah",
  "yogi adityanath",
  "arvind kejriwal",
  "bjp",
  "congress",
  "aap",
  "ncp",
  "shivsena",
  "tdp",
  "trs",
  "dmk",
  "aiadmk",
  "samajwadi party",
  "lok sabha",
  "rajya sabha",
  "parliament",
  "cabinet",
  "pm modi",
  "president of india",
  "election commission",
  "general elections",
  "state elections",
  "budget session",
  "rbi",
  "sebi",
  "irdai",
  "niti aayog",
  "finance ministry",
  "mca india",
  "income tax department",
  "gst council",
  "it department",
  "ed raids",
  "cbi",
  "supreme court of india",
  "nse",
  "bse",
  "sensex",
  "nifty",
  "mcx",
  "ncdex",
  "indian stock market",
  "stock market india",
  "bombay stock exchange",
  "national stock exchange",
  ".ns",
  ".bo",
  "upi",
  "paytm",
  "phonepe",
  "google pay",
  "bhim",
  "digital india",
  "fintech",
  "neobank",
  "stock broker india",
  "zerodha",
  "groww",
  "angel broking",
  "5paisa",
  "icicidirect",
  "sbi",
  "hdfc bank",
  "icici bank",
  "axis bank",
  "kotak bank",
  "pnb",
  "bank of baroda",
  "canara bank",
  "union bank",
  "idfc first bank",
  "yes bank",
  "reliance",
  "tata",
  "adani",
  "ambani",
  "vedanta",
  "hindalco",
  "itc",
  "l&t",
  "ongc",
  "coal india",
  "ntpc",
  "sail",
  "bharat electronics",
  "bharat forge",
  "bel",
  "bpcl",
  "ioc",
  "tcs",
  "infosys",
  "wipro",
  "hcl",
  "tech mahindra",
  "mindtree",
  "ltimindtree",
  "indigo",
  "air india",
  "spicejet",
  "gmr",
  "irctc",
  "nhai",
  "l&t",
  "railway stocks",
  "gdp india",
  "cpi",
  "inflation india",
  "repo rate",
  "interest rate hike",
  "monetary policy",
  "credit growth",
  "npas",
  "foreign exchange",
  "trade deficit",
  "current account deficit",
  "budget india",
  "union budget",
  "make in india",
  "startup india",
  "skill india",
  "digital india",
  "pm kisan",
  "pfi ban",
  "demonetisation",
  "gst",
  "income tax slab",
  "aadhar",
  "pan",
  "crude oil india",
  "petrol price",
  "diesel price",
  "gold price india",
  "silver price india",
  "natural gas india",
  "renewable energy india",
  "solar energy",
  "power grid",
  "india china",
  "india pakistan",
  "india us",
  "modi biden",
  "india russia",
  "brics",
  "g20 summit",
  "quad alliance",
  "defence deal india",
  "foreign policy india",
  "fta with eu",
  "ipo",
  "fpo",
  "drhp",
  "rhp",
  "pre-ipo",
  "listing gain",
  "anchor investors",
  "qib",
  "stock market listing",
  "stock split",
  "bonus issue",
  "dividend announcement",
  "lic",
  "epfo",
  "mutual funds india",
  "sip",
  "aif",
  "pms",
  "nps india",
  "foreign institutional investor",
  "fii",
  "dii",
  "retail investors",
  "layoffs india",
  "hiring freeze",
  "moonlighting india",
  "esop",
  "founders",
  "startup funding",
  "series a funding",
  "unicorn india",
  "valuation drop",
  "debt restructuring",
  "nclt",
  "insolvency",
  "bankruptcy india",
  "wilful defaulter",
  "shell company",
  "corporate fraud",
  "enforcement directorate",
  "scam",
  "ponzi scheme",
  "cyber crime india",
  "hawala",
  "farmers protest",
  "caa",
  "nrc",
  "women reservation bill",
  "reservation quota",
  "manipur violence",
  "diwali",
  "holi",
  "eid",
  "dussehra",
  "onam",
  "pongal",
  "independence day",
  "republic day",
  "budget day",
  "rail budget",
  "vibrant gujarat",
  "g20 india",
  "ipl",
  "bcci",
  "cricket india",
  "virat kohli",
  "rohit sharma",
  "ms dhoni",
  "olympics india",
  "neeraj chopra",
  "pv sindhu",
  "kangana ranaut",
  "nirmala sitharaman",
  "rbi governor",
  "elon musk india",
  "nita ambani",
  "gautam adani",
  "ratan tata",
  "chatgpt india",
  "ai policy india",
  "cyber security india",
  "semiconductor india",
  "data protection bill",
  "it rules india",
  "digital rupee",
  "upi international",
  "gst evasion",
  "banking fraud",
  "data breach",
  "ed raid",
  "npa crisis",
  "rural economy",
  "defence deal",
  "military spending india",
  "infrastructure india",
  "green hydrogen"
];
// Added more keywords
                const indiaNews = allGeneralNewsForIndiaFilter.filter(article => {
                    const title = article.title ? article.title.toLowerCase() : '';
                    const content = article.content ? article.content.toLowerCase() : '';
                    const site = article.site ? article.site.toLowerCase() : '';
                    return indiaKeywords.some(keyword => title.includes(keyword) || content.includes(keyword) || site.includes(keyword));
                }).slice(0, INDIA_NEWS_GRID_COUNT); // Take top N articles after filtering

                if (indiaNews && indiaNews.length > 0) {
                    renderNews(indiaNews, indiaNewsContainer, 'grid');
                } else {
                    indiaNewsContainer.innerHTML = '<p class="no-news-message col-span-full">No India specific news found using current filters.</p>'; // Updated message
                }

                // 5. Fetch and render Stock Sentiments News Grid
                const stockNewsSentiments = await fetchNews(STOCK_SENTIMENTS_URL, 0, STOCK_SENTIMENTS_GRID_COUNT);
                if (stockNewsSentiments && stockNewsSentiments.length > 0) {
                    renderNews(stockNewsSentiments, stockSentimentsContainer, 'grid');
                } else {
                    stockSentimentsContainer.innerHTML = '<p class="no-news-message col-span-full">No stock sentiments news found.</p>';
                }

            } catch (error) {
                const errorMessage = `<p class="error-message col-span-full">Error loading news: ${error.message}. Please try again later.</p>`;
                featuredNewsContainer.innerHTML = '<h2 class="news-section-heading !text-left !mt-0 !mb-4 !border-b-2">Featured Story</h2>' + errorMessage;
                latestNewsList.innerHTML = errorMessage;
                generalNewsContainer.innerHTML = errorMessage;
                indiaNewsContainer.innerHTML = errorMessage;
                stockSentimentsContainer.innerHTML = errorMessage;
                console.error('Failed to load news from APIs:', error);
            } finally {
                // Hide loading messages after attempt, even if empty
                featuredNewsContainer.querySelector('.loading-message').style.display = 'none';
            }
        }


        // Stock Ticker Logic
        const tickerSymbols = [
            'RELIANCE', 'HINDUNILVR', 'HDFCBANK', 'BHARTIARTL', 'MARUTI', 'SBIN',
            'WIPRO', 'ICICIBANK', 'AXISBANK', 'KOTAKBANK',
            'ITC', 'LT', 'SUNPHARMA', 'ASIANPAINT', 'BAJFINANCE', 'NESTLEIND',
            'ULTRACEMCO', 'POWERGRID', 'NTPC', 'TITAN', 'TECHM', 'GRASIM',
            'ADANIENT', 'ADANIGREEN', 'ADANIPORTS', 'ONGC', 'COALINDIA', 'JSWSTEEL',
            'HCLTECH', 'BPCL', 'IOC', 'EICHERMOT', 'HEROMOTOCO', 'TATAMOTORS'
        ];

        async function fetchAndRenderStockTicker() {
            if (TWELVE_DATA_API_KEY === "") {
                stockTickerContent.innerHTML = '<div class="scroll-item text-red-600">API Key is empty. Cannot fetch stock data.</div>';
                return;
            }

            // Add .NSE to all symbols for Indian exchange, if not already present
            const symbolsWithExchange = tickerSymbols.map(symbol => symbol.includes('.') ? symbol : `${symbol}.NSE`);
            const symbolsString = symbolsWithExchange.join(',');
            const quoteApiUrl = `https://api.twelvedata.com/quote?symbol=${symbolsString}&apikey=${TWELVE_DATA_API_KEY}`;

            try {
                stockTickerContent.innerHTML = '<div class="scroll-item text-gray-400">Fetching stock data...</div>';

                const response = await fetch(quoteApiUrl);

                if (!response.ok) {
                    const errorText = await response.text();
                    console.error(`HTTP error fetching stock data! Status: ${response.status}, Body: ${errorText}`);
                    stockTickerContent.innerHTML = `<div class="scroll-item text-red-600">Error fetching data: ${response.status}. Check console.</div>`;
                    return;
                }

                const data = await response.json();

                stockTickerContent.innerHTML = ''; // Clear loading message

                const itemsToDuplicate = [];
                let foundValidData = false;

                if (data.status && data.status === 'error') {
                     console.error("Twelve Data API returned an error status:", data.message);
                     stockTickerContent.innerHTML = `<div class="scroll-item text-red-600">API Error: ${data.message}. Check console.</div>`;
                     return;
                }

                // Handle both single object and multiple object responses from Twelve Data
                const stockDataArray = Array.isArray(data) ? data : Object.values(data);

                stockDataArray.forEach(stockData => {
                    // Check if stockData is a valid object and not an error message
                    if (typeof stockData === 'object' && stockData !== null && stockData.symbol && stockData.close !== undefined && stockData.change !== undefined && stockData.percent_change !== undefined) {
                        foundValidData = true;
                        const symbol = stockData.symbol.split('.')[0]; // Remove .NSE if present
                        const price = parseFloat(stockData.close).toFixed(2);
                        const change = parseFloat(stockData.change).toFixed(2);
                        const changePercentage = parseFloat(stockData.percent_change).toFixed(2);

                        let colorClass = 'text-gray-700';
                        if (Math.sign(change) > 0) {
                            colorClass = 'text-green-500'; // Brighter green
                        } else if (Math.sign(change) < 0) {
                            colorClass = 'text-red-500'; // Brighter red
                        }

                        const scrollItem = document.createElement('div');
                        scrollItem.classList.add('scroll-item', 'text-sm');

                        scrollItem.innerHTML = `
                            <span class="font-semibold">${symbol}:</span>
                            <span class="text-white">${price}</span>
                            <span class="${colorClass}">${change > 0 ? '▲' : '▼'} ${Math.abs(change)} (${changePercentage}%)</span>
                        `;
                        itemsToDuplicate.push(scrollItem);
                    } else {
                       // console.warn(`Could not retrieve valid data for an item. Received:`, stockData);
                       // Add a placeholder for symbols that failed to load, so the ticker doesn't stop
                       const symbolFromError = stockData.symbol ? stockData.symbol.split('.')[0] : 'N/A';
                       const scrollItem = document.createElement('div');
                       scrollItem.classList.add('scroll-item', 'text-sm', 'text-yellow-400'); // Yellow for warnings
                       scrollItem.textContent = `${symbolFromError}: Data N/A`;
                       itemsToDuplicate.push(scrollItem);
                    }
                });

                if (!foundValidData && itemsToDuplicate.length === 0) {
                     stockTickerContent.innerHTML = '<div class="scroll-item text-red-600">No valid stock data received for any symbol. Check console for details.</div>';
                     console.error("Processed all symbols, but no valid data was found.");
                     return;
                }

                // Append items multiple times to ensure continuous scroll effect
                for(let i = 0; i < 2; i++) { // Duplicate twice
                    itemsToDuplicate.forEach(item => stockTickerContent.appendChild(item.cloneNode(true)));
                }


                if (stockTickerContent.children.length > 0) {
                     stockTickerContent.style.animation = 'scroll 30s linear infinite';
                 } else {
                     stockTickerContent.innerHTML = '<div class="scroll-item text-red-600">No stock data to display.</div>';
                 }


            } catch (error) {
                console.error("Fetch Error fetching stock data:", error);
                stockTickerContent.innerHTML = '<div class="scroll-item text-red-600">Failed to fetch stock data. Check console for network or CORS errors.</div>';
            }
        }

        // Load all dynamic content when the page finishes loading
        window.addEventListener('load', () => {
            loadAllNews();
            fetchAndRenderStockTicker();
        });
    </script>
</body>
</html>
@endsection
