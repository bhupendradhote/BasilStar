@extends('layouts.newsDashboardLayout')

@section('title', 'news_detail')

@section('content')
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f7f9;
        }
        .container {
            flex-direction: column !important;
        }

        /* Article Detail Styling */
        .article-card {
            background-color: #fff;
            border-radius: 0.75rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            padding: 2rem;
        }
        .article-card img {
            width: 100%;
            height: auto;
            max-height: 400px;
            object-fit: cover;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
        }
        .article-card h1 {
            font-size: 2.25rem;
            font-weight: 800;
            color: #1f2937;
            margin-bottom: 1rem;
            line-height: 1.2;
        }
        .article-meta {
            font-size: 0.875rem;
            color: #6b7280;
            margin-bottom: 1.5rem;
        }
        .article-content p {
            font-size: 1rem;
            color: #374151;
            line-height: 1.7;
            margin-bottom: 1rem;
        }
        .article-content p:last-child {
            margin-bottom: 0;
        }

        /* Similar News Styling */
        .similar-news-heading {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 3px solid #3b82f6;
        }
        .similar-news-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            padding: 1rem;
            background-color: #fff;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: box-shadow 200ms ease-in-out, transform 200ms ease-in-out;
            cursor: pointer;
        }
        .similar-news-item:hover {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
        }
        .similar-news-item img {
            width: 100px;
            height: 75px;
            object-fit: cover;
            border-radius: 0.25rem;
            flex-shrink: 0;
        }
        .similar-news-item .content {
            flex-grow: 1;
        }
        .similar-news-item h4 {
            font-weight: 600;
            color: #1f2937;
            font-size: 0.95rem;
            line-height: 1.4;
            margin-bottom: 0.25rem;
        }
        .similar-news-item p {
            font-size: 0.75rem;
            color: #6b7280;
        }

        /* Loading and Error Messages */
        .loading-message, .error-message, .no-content-message {
            text-align: center;
            color: #6b7280;
            margin-top: 2rem;
            padding: 1rem;
            background-color: #fff;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        .error-message {
            color: #dc2626;
        }
    </style>

    <main class="container mx-auto px-6 py-8 grid grid-cols-1 lg:grid-cols-3 gap-6">
        <section class="lg:col-span-2">
            <div id="article-detail-container">
                <p class="loading-message">Loading article details...</p>
            </div>
        </section>

        <section class="lg:col-span-1">
            <h2 class="similar-news-heading">SIMILAR NEWS</h2>
            <div id="similar-news-container" class="space-y-4">
                <p class="loading-message">Loading similar news...</p>
            </div>
        </section>
    </main>

    <script>
        const FMP_API_KEY = 'T8HogSezq0WNy97WinOjjLMEOuiKjnu5';
        const FMP_ARTICLES_URL = 'https://financialmodelingprep.com/api/v3/fmp/articles';
        const GENERAL_NEWS_URL = 'https://financialmodelingprep.com/api/v4/general_news';
        const STOCK_NEWS_URL = 'https://financialmodelingprep.com/api/v3/stock_news';

        const articleDetailContainer = document.getElementById('article-detail-container');
        const similarNewsContainer = document.getElementById('similar-news-container');

        /**
         * Fetches news from a given API endpoint.
         * @param {string} url - The API endpoint URL.
         * @param {number} page - The page number for pagination.
         * @param {number} size - The number of items per page.
         * @returns {Promise<Array>} A promise that resolves to an array of articles.
         */
        async function fetchNews(url, page = 0, size = 5) {
            try {
                const response = await fetch(`${url}?page=${page}&size=${size}&apikey=${FMP_API_KEY}`);
                if (!response.ok) {
                    const errorText = await response.text();
                    console.error(`Error fetching news from ${url}:`, response.status, errorText);
                    throw new Error(`Error fetching news: ${response.status}`);
                }
                const data = await response.json();
                // Normalize the response to always return an array of articles.
                if (data && data.content) {
                    return data.content;
                } else if (Array.isArray(data)) {
                    return data;
                }
                return [];
            } catch (error) {
                console.error(`Network or parsing error for ${url}:`, error);
                return [];
            }
        }

        /**
         * Renders the main article details.
         * @param {Object} article - The article object to render.
         */
        function renderArticleDetail(article) {
            let imageUrl = article.image || article.image_url || 'https://placehold.co/800x400/e2e8f0/000?text=No+Image';
            let title = article.title || 'No Title Available';
            let publishedAt = new Date(article.publishedDate || article.date || Date.now()).toLocaleDateString();
            let source = article.site || article.source || 'N/A';
            let content = (article.text || article.snippet || article.content || 'No detailed description available.').replace(/<[^>]*>?/gm, '');

            articleDetailContainer.innerHTML = `
                <div class="article-card">
                    <img src="${imageUrl}" alt="${title}" onerror="this.onerror=null; this.src='https://placehold.co/800x400/e2e8f0/000?text=No+Image'">
                    <h1>${title}</h1>
                    <p class="article-meta">
                        <span class="font-semibold">Source:</span> ${source} |
                        <span class="font-semibold">Published:</span> ${publishedAt}
                    </p>
                    <div class="article-content">
                        ${content.split('\n').map(p => `<p>${p}</p>`).join('')}
                    </div>
                </div>
            `;
        }

        /**
         * Renders similar news items.
         * @param {Array} articles - Array of similar news articles.
         */
        function renderSimilarNews(articles) {
            similarNewsContainer.innerHTML = '';

            if (articles.length === 0) {
                similarNewsContainer.innerHTML = '<p class="no-content-message">No similar news found.</p>';
                return;
            }

            articles.forEach(article => {
                let imageUrl = article.image || article.image_url || 'https://placehold.co/100x75/e2e8f0/000?text=News';
                let title = article.title || 'No Title';
                let publishedAt = new Date(article.publishedDate || article.date || Date.now()).toLocaleDateString();
                let articleUrl = `/news/${encodeURIComponent(article.symbol || article.title || article.id)}`;

                const newsItem = document.createElement('a');
                newsItem.href = articleUrl;
                newsItem.classList.add('similar-news-item');
                newsItem.innerHTML = `
                    <img src="${imageUrl}" alt="News Image" onerror="this.onerror=null; this.src='https://placehold.co/100x75/e2e8f0/000?text=News'">
                    <div class="content">
                        <h4>${title}</h4>
                        <p>${publishedAt}</p>
                    </div>
                `;
                similarNewsContainer.appendChild(newsItem);
            });
        }

        /**
         * Loads the main article and similar news based on URL parameter.
         */
        async function loadArticleAndSimilarNews() {
            // Get the article ID from the URL path (since we're using Laravel route parameter)
            const pathParts = window.location.pathname.split('/');
            let articleId = pathParts[pathParts.length - 1]; // Get the last part of the path
            articleId = decodeURIComponent(articleId); // Decode URL-encoded characters

            if (!articleId) {
                articleDetailContainer.innerHTML = '<p class="error-message">Article ID not provided in URL. Please navigate from the dashboard.</p>';
                similarNewsContainer.innerHTML = '<p class="no-content-message">Cannot load similar news without a main article.</p>';
                return;
            }

            // --- Fetch Main Article ---
            let mainArticle = null;
            try {
                // First try to find by symbol (for ticker URLs like /news/AEM)
                if (articleId.length <= 5 && /^[A-Z]+$/.test(articleId)) {
                    // This looks like a stock ticker
                    const stockNews = await fetchNews(STOCK_NEWS_URL, 0, 50);
                    mainArticle = stockNews.find(article => 
                        article.symbol === articleId
                    );
                }

                // If not found by symbol, try to find by title (for title URLs)
                if (!mainArticle) {
                    const allArticles = await Promise.all([
                        fetchNews(FMP_ARTICLES_URL, 0, 50),
                        fetchNews(GENERAL_NEWS_URL, 0, 50),
                        fetchNews(STOCK_NEWS_URL, 0, 50)
                    ]);
                    
                    // Combine all articles from different endpoints
                    const combinedArticles = [].concat(...allArticles);
                    
                    // Try to find by title match
                    mainArticle = combinedArticles.find(article => 
                        article.title && article.title.includes(articleId)
                    );

                    // If still not found, try to find by partial title match
                    if (!mainArticle) {
                        const searchTerms = articleId.split(' ').slice(0, 3); // Take first 3 words
                        mainArticle = combinedArticles.find(article => 
                            article.title && searchTerms.some(term => 
                                article.title.toLowerCase().includes(term.toLowerCase())
                            )
                        );
                    }
                }

                if (mainArticle) {
                    renderArticleDetail(mainArticle);
                } else {
                    articleDetailContainer.innerHTML = `
                        <div class="article-card">
                            <h1>${articleId}</h1>
                            <p class="no-content-message">Could not find detailed information for this article.</p>
                            <p>You might want to check back later or return to the <a href="/news" class="text-blue-500 hover:text-blue-700">news dashboard</a>.</p>
                        </div>
                    `;
                }
            } catch (error) {
                articleDetailContainer.innerHTML = `
                    <div class="error-message">
                        Failed to load article details: ${error.message}
                        <p>Please try again later or return to the <a href="/news" class="text-blue-500 hover:text-blue-700">news dashboard</a>.</p>
                    </div>
                `;
                console.error("Error fetching main article:", error);
            }

            // --- Fetch Similar News ---
            // Only fetch similar news if the main article was found
            if (mainArticle) {
                try {
                    const keywords = (mainArticle.title || articleId).split(' ').slice(0, 5).join(' ').toLowerCase();
                    const allGeneralNews = await fetchNews(GENERAL_NEWS_URL, 0, 50);

                    const similarNews = allGeneralNews.filter(article => {
                        // Exclude the main article itself from similar news
                        if (mainArticle.id && article.id === mainArticle.id) {
                            return false;
                        }
                        if (mainArticle.title && article.title === mainArticle.title) {
                            return false;
                        }
                        
                        const articleTitle = article.title ? article.title.toLowerCase() : '';
                        const articleContent = article.content ? article.content.toLowerCase() : '';
                        return keywords.split(' ').some(keyword => 
                            keyword && keyword.length > 3 && // Only search for meaningful keywords
                            (articleTitle.includes(keyword) || articleContent.includes(keyword))
                        );
                    }).slice(0, 5);

                    renderSimilarNews(similarNews);

                } catch (error) {
                    similarNewsContainer.innerHTML = `<p class="error-message">Failed to load similar news: ${error.message}</p>`;
                    console.error("Error fetching similar news:", error);
                }
            } else {
                 similarNewsContainer.innerHTML = '<p class="no-content-message">Cannot load similar news as the main article was not found.</p>';
            }
        }

        // Load content when the page is ready
        window.addEventListener('load', loadArticleAndSimilarNews);
    </script>
@endsection