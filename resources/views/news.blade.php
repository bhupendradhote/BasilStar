@extends('layouts.dashboardLayout')

@section('title', 'Market News Dashboard')

@section('content')

<style>
    /* public/css/style.css */

/* General Body and Container */
body {
    font-family: 'Inter', sans-serif; /* Using Inter font */
    background-color: #f4f7f6; /* Light background */
    color: #333;
}

.container {
    max-width: 1200px; /* Max width for content */
}

.section-heading, .similar-news-heading {
    font-size: 1.8em;
    font-weight: bold;
    margin-top: 30px;
    margin-bottom: 20px;
    color: #1a202c;
    border-bottom: 2px solid #4299e1; /* Blue underline */
    padding-bottom: 10px;
}

/* Loading, Error, No News Messages */
.loading, .error, .no-news {
    text-align: center;
    font-size: 1.2em;
    color: #555;
    margin-top: 20px;
    padding: 15px;
    background-color: #e2e8f0; /* Light gray background */
    border-radius: 5px;
}

.error {
    color: #c53030; /* Red color for errors */
    background-color: #fed7d7; /* Light red background */
}

/* Main News List Grid */
.news-container {
    display: grid;
    gap: 24px; /* Gap between news articles */
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); /* Responsive grid */
}

/* Individual News Article Card */
.news-article {
    background-color: #ffffff; /* White background for articles */
    border-radius: 8px; /* Rounded corners */
    overflow: hidden; /* Hide overflow for images */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Subtle shadow */
    display: flex;
    flex-direction: column; /* Stack content vertically */
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out; /* Smooth hover effects */
    cursor: pointer; /* Indicate clickable */
    border: 1px solid #e2e8f0; /* Subtle border */
}

.news-article:hover {
    transform: translateY(-5px); /* Lift effect on hover */
    box-shadow: 0 8px 12px rgba(0, 0, 0, 0.15); /* Larger shadow on hover */
}

.article-image {
    width: 100%;
    height: 200px; /* Fixed height for images */
    object-fit: cover; /* Cover the area without distorting aspect ratio */
    border-bottom: 1px solid #e2e8f0; /* Separator below image */
}

/* Placeholder for missing image */
.article-image.bg-gray-200 {
     display: flex;
     align-items: center;
     justify-content: center;
     text-align: center;
     color: #718096;
     font-size: 0.9em;
     background-color: #e2e8f0;
     height: 200px; /* Match image height */
     border-bottom: 1px solid #cbd5e0;
}


.article-content {
    padding: 16px; /* Padding inside the article card */
    flex-grow: 1; /* Allow content to take available space */
    display: flex;
    flex-direction: column;
}

.article-title {
    font-size: 1.25rem; /* Larger title font */
    font-weight: bold;
    margin-bottom: 8px;
    color: #1a202c; /* Darker title color */
}

.article-title a {
    color: inherit; /* Link color same as title */
    text-decoration: none; /* No underline by default */
}

.article-title a:hover {
    text-decoration: underline; /* Underline on hover */
    color: #3182ce; /* Blue on hover */
}

.article-snippet {
    font-size: 0.9rem;
    color: #4a5568; /* Grayish snippet color */
    margin-bottom: 12px;
    flex-grow: 1; /* Allow snippet to grow */
    line-height: 1.5;
    /* Limit snippet lines */
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
}

.article-meta {
    font-size: 0.8rem;
    color: #718096; /* Lighter meta color */
    margin-top: auto; /* Push meta to the bottom */
    border-top: 1px solid #e2e8f0;
    padding-top: 8px;
}

/* Styles for the Details View */
#details-view {
    /* Managed by JS: display: none/block */
}

.details-article {
    background-color: #ffffff;
    border-radius: 8px;
    padding: 24px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    margin-bottom: 24px;
    border: 1px solid #e2e8f0;
}

.details-article img {
    max-width: 100%;
    height: auto;
    border-radius: 4px;
    margin-bottom: 20px;
    display: block; /* Ensure image doesn't have extra space below */
    margin-left: auto;
    margin-right: auto;
}

.details-article h2 {
    font-size: 2em;
    font-weight: bold;
    margin-bottom: 15px;
    color: #1a202c;
    line-height: 1.3;
}

.details-article .meta {
    font-size: 0.9em;
    color: #718096;
    margin-bottom: 20px;
    border-bottom: 1px solid #eee;
    padding-bottom: 20px;
}

.details-article p {
    font-size: 1.1em;
    line-height: 1.8;
    color: #4a5568;
    margin-bottom: 20px;
}

.details-article a {
    color: #3182ce; /* Blue link */
    text-decoration: none;
}

.details-article a:hover {
    text-decoration: underline;
}


/* Back Button */
.back-button {
    display: inline-flex; /* Use flex for alignment */
    align-items: center;
    gap: 5px; /* Space between arrow and text */
    margin-bottom: 20px;
    padding: 8px 16px;
    background-color: #4299e1; /* Blue background */
    color: white;
    border-radius: 4px;
    text-decoration: none;
    transition: background-color 0.2s ease-in-out;
    font-size: 0.9em;
}

.back-button:hover {
    background-color: #3182ce; /* Darker blue on hover */
}

/* Similar News List Styling */
.similar-news-list {
    display: flex; /* Stack similar news vertically */
    flex-direction: column;
    gap: 15px; /* Space between similar news items */
}

.similar-news-list .news-article {
    margin-bottom: 0; /* Remove bottom margin from general news-article */
    padding-bottom: 15px; /* Add padding for border */
    border-bottom: 1px solid #e2e8f0; /* Separator */
    box-shadow: none; /* Remove shadow */
    border-radius: 0; /* Remove border radius */
    flex-direction: row; /* Horizontal layout */
    gap: 15px;
    background-color: transparent; /* No background */
    padding: 0; /* Remove padding */
    transition: background-color 0.2s ease-in-out;
}

.similar-news-list .news-article:hover {
     background-color: #f7fafc; /* Subtle hover background */
     transform: none; /* No lift effect */
     box-shadow: none; /* No shadow */
}

.similar-news-list .news-article:last-child {
    border-bottom: none; /* No border after last item */
    padding-bottom: 0;
}

.similar-news-list .article-image {
    width: 120px; /* Fixed smaller image width */
    height: 80px; /* Fixed smaller image height */
    flex-shrink: 0; /* Prevent shrinking */
    border-radius: 4px;
    object-fit: cover;
    border-bottom: none; /* Remove bottom border */
}

.similar-news-list .article-image.bg-gray-200 {
     width: 120px;
     height: 80px;
     flex-shrink: 0;
     border-bottom: none;
     border-radius: 4px;
     font-size: 0.7em;
}

.similar-news-list .article-content {
    padding: 0; /* Remove padding */
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    justify-content: center; /* Vertically align content */
}

.similar-news-list .article-title {
    font-size: 1em; /* Smaller title */
    margin-bottom: 5px;
    line-height: 1.4;
}

.similar-news-list .article-snippet {
    font-size: 0.8em; /* Smaller snippet */
    margin-bottom: 5px;
     -webkit-line-clamp: 2; /* Limit snippet to 2 lines */
}

.similar-news-list .article-meta {
    font-size: 0.7em; /* Smaller meta */
    border-top: none; /* Remove border */
    padding-top: 0;
}


/* Trending Entities Styling */
.trending-entities-list {
    display: flex;
    flex-wrap: wrap; /* Allow items to wrap */
    gap: 10px; /* Space between entities */
    padding: 10px 0;
    border-radius: 5px;
    background-color: #ffffff;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
    border: 1px solid #e2e8f0;
}

.trending-entity-item {
    background-color: #ebf8ff; /* Light blue background */
    color: #2b6cb0; /* Darker blue text */
    padding: 6px 12px;
    border-radius: 20px; /* Pill shape */
    font-size: 0.9em;
    cursor: pointer;
    transition: background-color 0.2s ease-in-out, transform 0.1s ease-in-out;
    border: 1px solid #bee3f8; /* Light blue border */
}

.trending-entity-item:hover {
    background-color: #bee3f8; /* Slightly darker blue on hover */
    transform: translateY(-2px); /* Subtle lift */
}

.trending-entity-item .sentiment {
    font-weight: bold;
}

.trending-entity-item .count {
    font-size: 0.8em;
    color: #4c7d9f; /* Grayish-blue for count */
}

.trending-entity-item .sentiment.positive { color: #38a169; } /* Green for positive sentiment */
.trending-entity-item .sentiment.negative { color: #e53e3e; } /* Red for negative sentiment */
.trending-entity-item .sentiment.neutral { color: #718096; } /* Gray for neutral sentiment */
</style>

<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold text-center mb-8 text-gray-800" id="main-heading"></h1>

    {{-- Main News View --}}
    <div id="main-view">
        {{-- Trending Entities Section --}}
        <div class="mb-8">
            <h2 class="section-heading">Trending Entities (<span id="trending-country"></span>)</h2>
            <div id="trending-entities-container" class="trending-entities-list">
                <div class="loading text-center text-gray-600">Loading trending entities...</div>
            </div>
        </div>

        {{-- Main News List Section --}}
        <h2 class="section-heading" id="main-news-heading">Latest Market News</h2>
        <div id="news-container" class="news-container">
            <div class="loading text-center text-gray-600">Loading news...</div>
        </div>
    </div>

    {{-- Article Details View --}}
    <div id="details-view" class="hidden">
        <a href="#" id="back-button" class="back-button">&larr; Back to News</a>
        <div id="selected-article-details" class="details-article">
            {{-- Article details will be loaded here by JavaScript --}}
        </div>

        {{-- Similar News Section --}}
        <h2 class="similar-news-heading">Similar News</h2>
        <div id="similar-news-container" class="similar-news-list news-container">
            <div class="loading text-center text-gray-600">Loading similar news...</div>
        </div>
    </div>
</div>


@endsection