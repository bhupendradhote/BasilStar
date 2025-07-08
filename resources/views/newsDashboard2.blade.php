@extends('layouts.newsDashboardLayout')

@section('title', 'Financial News Dashboard')

@section('content')
    {{-- Main content wrapper with responsive padding and max-width --}}
    <div class="w-full">
        {{-- Flex container for the main three-column layout on large screens --}}
        <div class="flex-container">
            
            
            {{-- About BasilStar--}}
            <section class="news-section-1 min-h-[700px] text-white flex items-center">
                      <div class="grid grid-cols-1 md:grid-cols-2 w-full h-full relative bg-cover bg-no-repeat bg-center">
                    
                        <div class="front-hero px-4 relative z-10 px-4 flex flex-col items-start justify-center h-full w-full">
                          <div class="mb-8">
                            <div class="play-button-circle">
                              <div class="play-button-triangle"></div>
                            </div>
                          </div>
                    
                          <h4 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold leading-tight mb-4 drop-shadow-lg text-start">
                            Why Choose <span class="text-green-400">BasilStar</span>
                          </h4>
                          
                          <p class="text-lg md:text-xl text-gray-200 mb-8 max-w-2xl text-center">
                            BasilStar Help you to connect with the corrent network and updates.
                          </p>
                          
                          <button class="bg-green-600 hover:bg-green-700 text-white font-bold 
                                                  py-2 px-4 sm:py-2.5 sm:px-6 md:py-3 md:px-8 
                                                  text-sm sm:text-base md:text-lg 
                                                  rounded-full shadow-lg transition duration-300">
                            Learn More
                          </button>
                        </div>
                        
                        
                        <div class="front-hero px-4 relative z-10 px-4 flex flex-col items-start justify-center h-full w-full">
                            <div class="mb-8">
                            <div class="play-button-circle">
                              <div class="play-button-triangle"></div>
                            </div>
                          </div>
                    
                          <h4 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold leading-tight mb-4 drop-shadow-lg text-start">
                           How BasilStar<br/><span class="text-green-400"> is UseFull</span>
                          </h4>
                          
                          <p class="text-lg md:text-xl text-gray-200 mb-8 max-w-2xl text-center">
                            Your trusted partner in renewable energy solutions.
                          </p>
                          
                          <button class="bg-green-600 hover:bg-green-700 text-white font-bold 
                                          py-2 px-4 sm:py-2.5 sm:px-6 md:py-3 md:px-8 
                                          text-sm sm:text-base md:text-lg 
                                          rounded-full shadow-lg transition duration-300">
                            Learn More
                          </button>
                        </div>
                      </div>
                    </section>

                

            {{-- INDIA NEWS --}}
            <section class="news-section">
                <h2 class="section-heading" id="news-category-heading">INDIA NEWS</h2>
                
                <h1 class="text-white md:text-[60px] ">
                    Empowering a Sustainable Future with Cutting-Edge Renewable Energy Solutions
                </h1>
                
                <div class="flex">
                    
                <div id="business-news-container" class="news-container">
                    {{-- News articles will be loaded here by JS --}}
                    <p class="loading-text">Loading news...</p>
                    {{-- Example placeholder news item --}}
                    <div class="news-item-placeholder">
                        <h3 class="news-title">Indian Economy Shows Robust Growth in Q1</h3>
                        <p class="news-snippet">Latest reports indicate a strong rebound in manufacturing and service sectors, boosting investor confidence.</p>
                        <span class="news-meta">1 hour ago | Source: Economic Times</span>
                    </div>
                    <div class="news-item-placeholder">
                        <h3 class="news-title">Tech Startups Attract Record Investments</h3>
                        <p class="news-snippet">Venture capital funding surges for innovative Indian tech companies, particularly in AI and SaaS.</p>
                        <span class="news-meta">3 hours ago | Source: Livemint</span>
                    </div>
                </div>
                <div>
                    <h1>this is About India news. The news to connect people together and the updates.</h1>
                </div>
                </div>
                <button id="load-more-main" class="load-more-button hidden">Load More</button>
            </section>

            {{-- PREDICTION & ANALYSIS --}}
            <section class="news-section">
                <h2 class="section-heading">PREDICTION & ANALYSIS</h2>
                <div id="prediction-analysis-container" class="prediction-analysis-container">
                    {{-- Prediction/Analysis content will be loaded here by JS or backend --}}
                    <p class="loading-text full-width-placeholder">Loading predictions and analysis...</p>
                    {{-- Example placeholder content --}}
                    <div class="prediction-item-placeholder">
                        <h3 class="prediction-title">Nifty 50 Technical Outlook</h3>
                        <p class="prediction-snippet">Support at 24800, Resistance at 25200. Sideways momentum expected with high volatility.</p>
                    </div>
                    <div class="prediction-item-placeholder">
                        <h3 class="prediction-title">Stock Pick of the Day: ABC Ltd.</h3>
                        <p class="prediction-snippet">Buy ABC Ltd. around ₹1200 with target ₹1280. Stop loss at ₹1185. Strong fundamentals.</p>
                    </div>
                    <div class="prediction-item-placeholder full-width-placeholder">
                        <h3 class="prediction-title">Sectoral Analysis: IT vs. Pharma</h3>
                        <p class="prediction-snippet">IT sector showing signs of correction, while Pharma poised for growth due to new policy announcements.</p>
                    </div>
                </div>
                <button id="load-more-prediction" class="load-more-button hidden">Load More</button>
            </section>

            {{-- WATCHLIST, MARKET OVERVIEW, INDICES, CHART, TOP MOVERS --}}
            <section class="flex flex-wrap justify-evenly gap-10">
                <div>
                <h2 class="section-heading">MY WATCHLIST</h2>
                <div class="watchlist-container">
                    {{-- Watchlist Items (Example Static) --}}
                    <div class="watchlist-item">
                        <div>
                            <div class="watchlist-symbol">TCS</div>
                            <div class="watchlist-name">Tata Consultancy Services</div>
                        </div>
                        <div class="text-right">
                            <div class="watchlist-price green">3,850.20</div>
                            <div class="watchlist-change green">+35.10 (0.92%)</div>
                        </div>
                    </div>
                    <div class="watchlist-item">
                        <div>
                            <div class="watchlist-symbol">INFY</div>
                            <div class="watchlist-name">Infosys</div>
                        </div>
                        <div class="text-right">
                            <div class="watchlist-price red">1,589.75</div>
                            <div class="watchlist-change red">-23.50 (-1.46%)</div>
                        </div>
                    </div>
                    <div class="watchlist-item">
                        <div>
                            <div class="watchlist-symbol">HDFC</div>
                            <div class="watchlist-name">HDFC Bank</div>
                        </div>
                        <div class="text-right">
                            <div class="watchlist-price gray">1,450.00</div>
                            <div class="watchlist-change gray">0.00 (0.00%)</div>
                        </div>
                    </div>
                    <div class="watchlist-item">
                        <div>
                            <div class="watchlist-symbol">RELIANCE</div>
                            <div class="watchlist-name">Reliance Industries</div>
                        </div>
                        <div class="text-right">
                            <div class="watchlist-price red">1,933.60</div>
                            <div class="watchlist-change red">-17.80 (-0.92%)</div>
                        </div>
                    </div>
                </div>
                </div>

                {{-- MARKET OVERVIEW --}}
                <div class="w-80">
                    
                <h2 class="section-heading top-margin">MARKET OVERVIEW</h2>
                <div class="market-overview-box">
                    <h3 class="market-overview-title">Market Prediction for Next Trading Session</h3>
                    <p class="market-overview-link">
                        Explore On Dhan <i class="fas fa-external-link-alt ml-2 text-xs"></i>
                    </p>
                    <p class="market-overview-text">
                        Global cues remain mixed. Domestic market sentiment positive on economic data. Expect consolidation with potential for late-day rally.
                    </p>
                </div>
                </div>

                {{-- KEY INDICES (Static) --}}
                <div>
                    
                <h2 class="section-heading top-margin">KEY INDICES</h2>
                <div class="key-indices-container">
                    <div class="key-index-item">
                        <div class="index-symbol">SENSEX</div>
                        <div class="index-value">82,330.59</div>
                        <div class="index-change red">-200.15 (-0.24%)</div>
                    </div>
                    <div class="key-index-item">
                        <div class="index-symbol">NIFTY</div>
                        <div class="index-value">25,019.80</div>
                        <div class="index-change red">-42.30 (-0.17%)</div>
                    </div>
                    <div class="key-index-item">
                        <div class="index-symbol">BANKNIFTY</div>
                        <div class="index-value">55,354.90</div>
                        <div class="index-change gray">-0.70 (0.00%)</div>
                    </div>
                </div>
                </div>
                
                {{-- CHART PLACEHOLDER --}}
                <div class="chart-box">
                    <h3 class="chart-title">SENSEX Chart (Placeholder)</h3>
                    {{-- Ensure image scales responsively --}}
                    <img src="https://placehold.co/600x400/e2e8f0/000?text=Chart+Placeholder" alt="Stock Chart" class="chart-image">
                </div>

                {{-- TOP MOVERS (Static) --}}
                <div>
                <h2 class="section-heading top-margin">TOP MOVERS</h2>
                <div class="top-movers-container">
                    <h3 class="top-movers-subtitle">Top Gainers</h3>
                    <div class="top-mover-item">
                        <div class="mover-symbol">Stock A (XYZ)</div>
                        <div class="mover-change green">+5.20%</div>
                    </div>
                    <div class="top-mover-item">
                        <div class="mover-symbol">Stock B (PQR)</div>
                        <div class="mover-change green">+4.80%</div>
                    </div>
                    <div class="top-mover-item">
                        <div class="mover-symbol">Stock C (LMN)</div>
                        <div class="mover-change green">+4.50%</div>
                    </div>

                    <h3 class="top-movers-subtitle second-group-margin">Top Losers</h3>
                    <div class="top-mover-item">
                        <div class="mover-symbol">Stock X (UVW)</div>
                        <div class="mover-change red">-3.50%</div>
                    </div>
                    <div class="top-mover-item">
                        <div class="mover-symbol">Stock Y (RST)</div>
                        <div class="mover-change red">-2.90%</div>
                    </div>
                    <div class="top-mover-item">
                        <div class="mover-symbol">Stock Z (FGH)</div>
                        <div class="mover-change red">-2.50%</div>
                    </div>
                </div>
                </div>
            </section>

            {{-- ECONOMY NEWS --}}
            <section class="news-section">
                <h2 class="section-heading">ECONOMY NEWS</h2>
                <div id="economy-news-container" class="news-container">
                    {{-- Economy news will be loaded here by JS or backend --}}
                    <p class="loading-text">Loading economy news...</p>
                    {{-- Example placeholder content --}}
                    <div class="news-item-placeholder">
                        <h3 class="news-title">RBI Holds Interest Rates Steady, Cites Inflation Concerns</h3>
                        <p class="news-snippet">Central bank maintains status quo on key rates amidst global economic uncertainties and domestic price pressures.</p>
                        <span class="news-meta">2 hours ago | Source: Reuters</span>
                    </div>
                    <div class="news-item-placeholder">
                        <h3 class="news-title">India's GDP Growth Forecast Revised Upwards for Next Fiscal Year</h3>
                        <p class="news-snippet">Leading analysts optimistic about sustained economic recovery driven by infrastructure spending and private consumption.</p>
                        <span class="news-meta">Yesterday | Source: Bloomberg</span>
                    </div>
                </div>
                <button id="load-more-economy" class="load-more-button hidden">Load More</button>
            </section>

            {{-- TECHNOLOGY NEWS --}}
            <section class="news-section">
                <h2 class="section-heading">TECHNOLOGY NEWS</h2>
                <div id="technology-news-container" class="news-container">
                    {{-- Technology news will be loaded here by JS or backend --}}
                    <p class="loading-text">Loading technology news...</p>
                    {{-- Example placeholder content --}}
                    <div class="news-item-placeholder">
                        <h3 class="news-title">Tech Stock Rallies on Strong Earnings Report</h3>
                        <p class="news-snippet">Leading software company announces better-than-expected quarterly results, pushing its stock to new highs.</p>
                        <span class="news-meta">4 hours ago | Source: TechCrunch</span>
                    </div>
                    <div class="news-item-placeholder">
                        <h3 class="news-title">New AI Chip Promises Significant Performance Boost</h3>
                        <p class="news-snippet">Breakthrough in semiconductor technology expected to accelerate AI processing in data centers and edge devices.</p>
                        <span class="news-meta">2 days ago | Source: Wired</span>
                    </div>
                </div>
                <button id="load-more-technology" class="load-more-button hidden">Load More</button>
            </section>

            {{-- STARTUPS NEWS --}}
            <section class="news-section">
                <h2 class="section-heading">STARTUPS NEWS</h2>
                <div id="startups-news-container" class="news-container">
                    {{-- Startups news will be loaded here by JS or backend --}}
                    <p class="loading-text">Loading startups news...</p>
                    {{-- Example placeholder content --}}
                    <div class="news-item-placeholder">
                        <h3 class="news-title">Fintech Startup Secures $20M in Series B Funding Round</h3>
                        <p class="news-snippet">Company plans to expand its digital lending platform and enter new markets with the fresh capital.</p>
                        <span class="news-meta">6 hours ago | Source: Forbes India</span>
                    </div>
                    <div class="news-item-placeholder">
                        <h3 class="news-title">EdTech Company Launches Innovative AI-Powered Learning Platform</h3>
                        <p class="news-snippet">Aims to personalize education and improve student engagement through adaptive learning technologies.</p>
                        <span class="news-meta">Last week | Source: Business Standard</span>
                    </div>
                </div>
                <button id="load-more-startups" class="load-more-button hidden">Load More</button>
            </section>
        </div> {{-- End of main flex container --}}
    </div> {{-- End of container --}}

    {{-- CSS Styles for Responsiveness --}}
    <style>


        /* Main Container */
        .container {
            min-width: 100%; /* Limit max width for large screens */
            background: white;
        }

        /* Flex Container for Main Sections */
        .flex-container {
            display: flex;
            flex-direction: column;
            flex-wrap: wrap; /* Allow items to wrap to the next line */
            justify-content: space-between; /* Distribute items evenly */
        }

        /* Styles for each news section */
        .news-section {
            width: 100%;
            background-color: #005550;
            padding: 1.5rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06); /* shadow-md */
            flex: 1 1 32%; /* Default for large screens: 3 columns */
            max-width: 100%; /* Ensure it doesn't overflow on small screens */
            display: flex; /* Make section content also a flex container */
            flex-direction: column; /* Stack content vertically */
        }
        
        .news-section-1{
             background-image: url('https://img.pikbest.com/wp/202405/coins-stack-3d-render-illustration-of-stacked-with-a-growing-plant-representing-investment-growth-profit-and-dividends-from-savings_9796700.jpg!w700wp');
             background-size: 100% 100%;
            width: 100%;
            padding: 1.5rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06); /* shadow-md */
            
        }

        /* Section Headings */
        .section-heading {
            font-size: 1.5rem; /* text-2xl */
            font-weight: bold;
            margin-bottom: 1.25rem; /* mb-5 */
            border-bottom: 1px solid #e5e7eb; /* border-b */
            padding-bottom: 0.75rem; /* pb-3 */
            color: white;
        }

        /* Placeholder Text for Loading */
        .loading-text {
            color: #4b5563; /* text-gray-600 */
            font-style: italic;
        }

        /* News Item Placeholders */
        .news-item-placeholder {
            border-bottom: 1px solid #e5e7eb; /* border-b */
            padding-bottom: 0.75rem; /* pb-3 */
            margin-bottom: 1rem; /* space-y-4 creates margin-bottom, but explicit for placeholders */
            display: flex;
            align-items: flex-start;
            gap: 1rem; /* space-x-4 */
        }
        .news-item-placeholder:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }
        .news-item-placeholder img {
            width: 6rem; /* w-24 */
            height: 5rem; /* h-20 */
            object-fit: cover;
            border-radius: 0.25rem; /* rounded */
            flex-shrink: 0; /* Prevent image from shrinking */
        }
        .news-item-placeholder > div { /* Content wrapper for text */
            flex-grow: 1;
        }
        .news-title {
            font-weight: 600; /* font-semibold */
            font-size: 1.125rem; /* text-lg */
            color: #1f2937; /* text-gray-900 */
            margin-bottom: 0.25rem; /* mb-1 */
        }
        .news-snippet {
            color: #374151; /* text-gray-700 */
            font-size: 0.875rem; /* text-sm */
            margin-top: 0.25rem; /* mt-1 */
        }
        .news-meta {
            color: #6b7280; /* text-gray-500 */
            font-size: 0.75rem; /* text-xs */
            display: block;
            margin-top: 0.25rem; /* mt-1 */
        }

        /* Prediction & Analysis Container */
        .prediction-analysis-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); /* Responsive grid for 2 columns */
            gap: 1rem; /* gap-4 */
            margin-bottom: 1.5rem; /* mb-6 */
        }

        .prediction-item-placeholder {
            background-color: #f9fafb; /* bg-gray-50 */
            padding: 1rem;
            border-radius: 0.5rem; /* rounded-lg */
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); /* shadow-sm */
            border: 1px solid #e5e7eb; /* border border-gray-200 */
            display: flex;
            flex-direction: column; /* Stack content vertically */
        }
        .prediction-item-placeholder img {
            width: 100%;
            height: 10rem; /* h-40 */
            object-fit: cover;
        }
        .prediction-title {
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.25rem;
            font-size: 1.125rem;
        }
        .prediction-snippet {
            color: #374151;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }
        .full-width-placeholder {
            grid-column: 1 / -1; /* Make this item span all columns in the grid */
        }

        /* Watchlist Container */
        .watchlist-container {
            margin-bottom: 1.5rem; /* mb-6 */
            background-color: #ffffff; /* bg-white */
            padding: 1rem; /* p-4 */
            border-radius: 0.5rem; /* rounded-lg */
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); /* shadow-sm */
            display: flex;
            flex-direction: column;
            gap: 0.75rem; /* space-y-3 */
        }
        .watchlist-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #e5e7eb; /* border-b */
            padding-bottom: 0.75rem; /* pb-3 */
        }
        .watchlist-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }
        .watchlist-symbol {
            font-weight: 600;
            color: #1f2937;
            font-size: 1.125rem; /* text-lg */
        }
        .watchlist-name {
            color: #4b5563;
            font-size: 0.875rem;
        }
        .watchlist-price {
            font-weight: bold;
            font-size: 1.125rem;
        }
        .watchlist-change {
            font-size: 0.75rem;
        }
        .green { color: #16a34a; } /* text-green-600 */
        .red { color: #dc2626; } /* text-red-600 */
        .gray { color: #374151; } /* text-gray-700 */

        /* Market Overview Box */
        .market-overview-box {
            background-color: #f9fafb; /* bg-gray-50 */
            padding: 1rem;
            border-radius: 0.5rem;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            margin-bottom: 1.5rem;
            border: 1px solid #e5e7eb;
        }
        .market-overview-title {
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.5rem;
            font-size: 1.125rem;
        }
        .market-overview-link {
            color: #2563eb; /* text-blue-600 */
            font-size: 0.875rem;
            display: flex;
            align-items: center;
        }
        .market-overview-link i {
            margin-left: 0.5rem;
            font-size: 0.75rem;
        }
        .market-overview-text {
            color: #374151;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        /* Key Indices Container */
        .key-indices-container {
            background-color: #f9fafb;
            padding: 1rem;
            border-radius: 0.5rem;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            display: flex;
            flex-wrap: wrap; /* Allow items to wrap */
            justify-content: space-around; /* Distribute items */
            text-align: center;
            font-size: 0.875rem;
            margin-bottom: 1.5rem;
            border: 1px solid #e5e7eb;
            gap: 1rem; /* Space between index items */
        }
        .key-index-item {
            flex-basis: calc(33.333% - 1rem); /* Approx 3 items per row, considering gap */
            min-width: 100px; /* Minimum width to prevent squishing */
            padding: 0.5rem;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .index-symbol {
            font-weight: 600;
            color: #374151;
            font-size: 1rem; /* text-base */
        }
        .index-value {
            font-weight: bold;
            color: #1f2937;
            font-size: 1.125rem; /* text-lg */
        }
        .index-change {
            font-size: 0.75rem;
        }

        /* Chart Box */
        .chart-box {
            background-color: #f9fafb;
            padding: 1rem;
            border-radius: 0.5rem;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            margin-bottom: 1.5rem;
            border: 1px solid #e5e7eb;
        }
        .chart-title {
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.75rem;
            font-size: 1.125rem;
        }
        .chart-image {
            max-width: 100%; /* Make image responsive */
            height: auto; /* Maintain aspect ratio */
            border-radius: 0.25rem;
        }

        /* Top Movers Container */
        .top-movers-container {
            background-color: #f9fafb;
            padding: 1rem;
            border-radius: 0.5rem;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
            gap: 1rem; /* space-y-3 */
            border: 1px solid #e5e7eb;
        }
        .top-movers-subtitle {
            font-weight: 600;
            color: #1f2937;
            border-bottom: 1px solid #d1d5db; /* border-b border-gray-300 */
            padding-bottom: 0.5rem; /* pb-2 */
            font-size: 1.125rem; /* text-lg */
        }
        .second-group-margin {
            padding-top: 1rem; /* pt-4 */
        }
        .top-mover-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.875rem; /* text-sm */
        }
        .mover-symbol {
            font-weight: 600;
            color: #1f2937;
        }
        .mover-change {
            font-weight: bold;
        }

        /* News Container for dynamically loaded news */
        .news-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-evenly;
            gap: 1rem; /* space-y-4 */
        }
        .news-container .news-item { /* Styles for actual news items loaded by JS */
            background-color: #ffffff; /* bg-white */
            padding: 1rem; /* p-4 */
            border-radius: 0.5rem; /* rounded-lg */
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); /* shadow-sm */
            display: flex;
            align-items: flex-start;
            gap: 1rem; /* space-x-4 */
            transition: all 0.2s ease-in-out; /* transition duration-200 */
            cursor: pointer;
        }
        .news-container .news-item:hover {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); /* hover:shadow-md */
        }
        .news-container .news-item img {
            width: 6rem; /* w-24 */
            height: 5rem; /* h-20 */
            object-fit: cover;
            border-radius: 0.25rem; /* rounded */
            flex-shrink: 0;
        }
        .news-container .news-item .para {
            /* For the snippet text and read more link */
            color: #374151; /* text-gray-700 */
            font-size: 0.875rem; /* text-sm */
            margin-top: 0.5rem;
            line-height: 1.5;
        }
        .news-container .news-item .text-blue-600 {
            color: #2563eb;
        }
        .news-container .news-item .text-blue-600:hover {
            text-decoration: underline;
        }

        /* Specific styles for prediction articles (already handled somewhat by prediction-item-placeholder) */
        /* If JS adds .news-item class, ensure these apply */
        .prediction-analysis-container .news-item {
            display: flex;
            flex-direction: column;
            padding: 0; /* No padding from news-item, padding comes from inner div */
        }
        .prediction-analysis-container .news-item img {
            width: 100%;
            height: 10rem; /* h-40 */
            object-fit: cover;
            border-radius: 0.5rem 0.5rem 0 0; /* Top corners rounded */
        }
        .prediction-analysis-container .news-item > div { /* The div containing text inside the news-item */
            padding: 1rem; /* p-4 */
        }
        .prediction-analysis-container .news-item .text-gray-500 {
            color: #6b7280;
        }


        /* Load More Button */
        .load-more-button {
            display: block;
            width: fit-content; /* Adjust width to content */
            margin: 1.5rem auto 0 auto; /* Centered, with top margin */
            padding: 0.75rem 1.5rem;
            background-color: #51fcb1; /* bg-blue-600 */
            color: #005550;
            border: none;
            border-radius: 0.375rem; /* rounded-md */
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s ease-in-out;
            text-align: center;
        }
        .load-more-button:hover {
            background-color: #005550; /* hover:bg-blue-700 */
            box-shadow: 0 0 0 1px #51fcb1;
            color: #51fcb1;
        }
        .load-more-button:disabled {
            background-color: #9ca3af; /* bg-gray-400 */
            cursor: not-allowed;
            
        }
        .load-more-button.hidden {
            display: none;
        }


        /* Article Detail Page Specific Styles */
        #article-detail-container {
            background-color: #ffffff;
            padding: 1.5rem;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem; /* space below detail */
        }
        #article-detail-container img {
            max-width: 100%;
            height: auto;
            object-fit: cover;
            border-radius: 0.25rem;
            margin-bottom: 1.5rem;
        }
        #article-detail-container h1 {
            font-size: 2rem;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 1rem;
        }
        #article-detail-container p {
            color: #4b5563;
            font-size: 0.875rem;
            margin-bottom: 1rem;
            line-height: 1.6;
        }
        #article-detail-container .text-gray-800 {
             color: #1f2937;
        }
        #article-detail-container a {
            color: #2563eb;
            text-decoration: none;
        }
        #article-detail-container a:hover {
            text-decoration: underline;
        }

        #similar-news-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
        }
        #similar-news-container .news-item {
             background-color: #ffffff; /* bg-white */
             padding: 1rem; /* p-4 */
             border-radius: 0.5rem; /* rounded-lg */
             box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); /* shadow-sm */
             display: flex;
             align-items: flex-start;
             gap: 1rem; /* space-x-4 */
             transition: all 0.2s ease-in-out; /* transition duration-200 */
             cursor: pointer;
        }
         #similar-news-container .news-item:hover {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); /* hover:shadow-md */
        }
        #similar-news-container .news-item img {
            width: 6rem; /* w-24 */
            height: 5rem; /* h-20 */
            object-fit: cover;
            border-radius: 0.25rem; /* rounded */
            flex-shrink: 0;
        }


        /* Media Queries for Responsiveness */

        /* Tablets and small desktops (smaller than 1024px, typical for lg: breakpoint) */
        @media screen and (max-width: 1023px) {
            .news-section {
                flex-basis: calc(50% - 0.75rem); /* Two columns, considering gap */
            }
             /* Adjust key indices to stack if needed, or expand for 2 columns */
             .key-indices-container {
                 grid-template-columns: repeat(2, 1fr); /* Two columns on smaller screens */
                 gap: 0.75rem;
             }
             .key-index-item {
                 flex-basis: 100%; /* Take full width within their own container */
             }
        }

        /* Mobile devices (smaller than 768px, typical for md: breakpoint) */
        @media screen and (max-width: 767px) {
            .container {
                padding: 1rem; /* Reduced padding on small screens */
            }
            .news-section {
                flex-basis: 100%; /* One column on mobile */
                margin-bottom: 1.5rem; /* Add margin when stacked vertically */
            }
            .news-section:last-child {
                margin-bottom: 0;
            }
            .section-heading {
                font-size: 1.25rem; /* text-xl */
                margin-bottom: 1rem;
                padding-bottom: 0.5rem;
            }
            .news-item-placeholder {
                flex-direction: column; /* Stack image and text */
                align-items: center;
                text-align: center;
            }
            .news-item-placeholder img {
                width: 100%; /* Full width image */
                height: auto; /* Auto height */
                max-height: 150px; /* Limit height */
                margin-bottom: 0.5rem;
            }
             .news-container .news-item {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }
            .news-container .news-item img {
                width: 100%;
                height: auto;
                max-height: 150px;
                margin-bottom: 0.5rem;
            }
            .prediction-analysis-container {
                grid-template-columns: 1fr; /* Single column on mobile */
            }
             .key-indices-container {
                 grid-template-columns: 1fr; /* Stack indices on very small screens */
                 gap: 0.5rem;
             }
             .key-index-item {
                 font-size: 0.75rem;
             }
             .watchlist-item {
                 flex-direction: column;
                 align-items: flex-start;
                 text-align: left;
             }
             .watchlist-item > div:last-child {
                 width: 100%;
                 display: flex;
                 justify-content: space-between;
                 margin-top: 0.25rem;
             }
        }
        
        .front-hero {
              animation: hero 1s ease-out forwards;
              overflow: hidden;
            }
            
            @keyframes hero {
              0% {
                transform: translateX(-10%);
                opacity: 0;
              }
              100% {
                transform: translateX(0%);
                opacity: 1;
              }
            }

        
          /* Custom styles for the background image and overlay */
        .hero-banner {
            background-image: url('https://img.pikbest.com/wp/202405/coins-stack-3d-render-illustration-of-stacked-with-a-growing-plant-representing-investment-growth-profit-and-dividends-from-savings_9796700.jpg!w700wp');'); /* Replace with the actual URL of your background image */
            background-size: 100% 100%;
            background-position: cover;
            background-repeat: no-repeat;
            position: relative;
            height: 100vh; /* Full viewport height */
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
            padding-bottom: 8rem; /* Space for the bottom "Your trusted partner" bar */
            
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5); /* 50% black overlay */
            z-index: 1;
        }

        /* Adjusting font for closer match - Montserrat seems plausible */
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #1a202c; /* Dark background color from the image */
        }

        /* Custom style for the play button circle and triangle */
        .play-button-circle {
            width: 60px; /* Adjust size as needed */
            height: 60px;
            background-color: rgba(76, 175, 80, 0.8); /* Green with transparency */
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .play-button-circle:hover {
            background-color: rgba(76, 175, 80, 1); /* Solid green on hover */
        }
        .play-button-triangle {
            width: 0;
            height: 0;
            border-top: 15px solid transparent;
            border-bottom: 15px solid transparent;
            border-left: 20px solid white; /* White triangle */
            margin-left: 5px; /* Adjust to center visually */
        }

        /* Specific gradient for the bottom info bar in the hero section */
        .info-bar-gradient {
             background: linear-gradient(to right, #2d3748, #4a5568); /* Dark gray gradient, adjust colors to match */
        }

        /* Adjust navigation height */
        .nav-height {
            height: 80px; /* Approximating the height of the nav bar in the image */
        }


    </style>
@endsection