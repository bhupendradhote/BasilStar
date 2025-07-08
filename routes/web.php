<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth; // Add this line
use App\Http\Controllers\MarketPredictionController;
use App\Http\Controllers\StrategyController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\BasketController;


use Illuminate\Support\Facades\Response;

Route::get('/data/nse_bse_symbols.json', function () {
    $path = public_path('data/nse_bse_symbols.json');

    if (!file_exists($path)) {
        abort(404, 'Symbol list not found.');
    }

    return Response::file($path, [
        'Content-Type' => 'application/json'
    ]);
});

// Public Authentication Routes - Using AuthController
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// --- Other Application Routes ---
Route::get('/', function () {
    return view(' /newsDashboard');
});

Route::get('/all_news', function () {
    return view('all_news');
});

// Route to handle the news detail page with an optional UUID parameter
// Route::get('/news_detail', [NewsController::class, 'showDetail'])->name('news.details');

Route::get('/news/{id}', function ($id) {
    return view('news_detail', ['id' => $id]);
})->name('news.detail');

Route::get('/about', function () {
    return view('about');
})->name('about');


Route::get('/contact', function () {
    return view('contact');
});


Route::get('/privacy', function () {
    return view('privacy');
});

Route::get('/terms', function () {
    return view('terms');
});



// Route::middleware('auth')->group(function () { 
    Route::get('/dashboard', function () {
        return view('layouts/dashboardLayout');
    });
    Route::get('/TradingDashboard', function () {
        return view(' /TradingDashboard');
    });

    Route::get('/liveChart', [MainController::class, 'showOnMainDashboard'])->name('dashboard.live');
    Route::get('/all-market-predictions', [MainController::class, 'showOnAllMarketPredictions'])->name('dashboard.all-predictions');
    Route::get('/all-strategies', [MainController::class, 'showOnAllStrategies'])->name('dashboard.all-strategies');
     Route::get('/all-baskets', [MainController::class, 'showAllBaskets'])->name('dashboard.all-baskets');



    Route::get('/chatbot', function () {
        return view(' /chatbot');
    });

    Route::get('/topGainerLosers', function () {
        return view(' /topGainerLosers');
    });
    Route::get('/marketPrediction', function () {
        return view(' /marketPrediction');
    });

    Route::get('/marketPredictionDetails', function () {
        return view(' /marketPredictionDetails');
    });

    Route::get('/ask-analyst', function () {
        return view(' /chatbot');
    });

    Route::get('/news', function () {
        return view(' /news');
    });

    // Route for the news dashboard page itself
    Route::get('/newsDashboard', function () {
        return view(' /newsDashboard');
    })->name('newsDashboard');


    Route::get('/services', function () {
        return view('services');
    });

    Route::get('/subscribe', function () {
        return view(' /subscription');
    });


    Route::get('/user', [UserController::class, 'show'])->name('user.profile'); // Example: show user profile

    // Route to fetch the user's current subscription status
    Route::get('/subscription', [SubscriptionController::class, 'index'])->name('subscription.status');

    // Route to handle storing a new subscription (e.g., after payment or direct subscription)
    Route::post('/subscribe', [SubscriptionController::class, 'store'])->name('subscribe.store');

    // Payment related routes - also protected by web auth
    Route::post('/payment', [PaymentController::class, 'initiatePayment'])->name('payment.initiate');
    Route::post('/create-razorpay-order', [PaymentController::class, 'createRazorpayOrder'])->name('create.razorpay.order');
    Route::post('/verify-razorpay-payment', [PaymentController::class, 'verifyRazorpayPayment'])->name('verify.razorpay.payment');

// });

    // Admin Dashboard Routes - also protected by web auth
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        
        Route::get('strategy', [StrategyController::class, 'index'])->name('strategy.index');
        Route::get('strategy/create', [StrategyController::class, 'create'])->name('strategy.create');
        Route::post('strategy', [StrategyController::class, 'store'])->name('strategy.store');
        Route::get('strategy/{id}/edit', [StrategyController::class, 'edit'])->name('strategy.edit');
        Route::put('strategy/{id}', [StrategyController::class, 'update'])->name('strategy.update');
        Route::delete('strategy/{id}', [StrategyController::class, 'destroy'])->name('strategy.destroy');
        
        Route::get('market-prediction', [MarketPredictionController::class, 'index'])->name('market-prediction.index');
        Route::get('market-prediction/create', [MarketPredictionController::class, 'create'])->name('market-prediction.create');
        Route::post('market-prediction', [MarketPredictionController::class, 'store'])->name('market-prediction.store');
        Route::get('market-prediction/{id}/edit', [MarketPredictionController::class, 'edit'])->name('market-prediction.edit');
        Route::put('market-prediction/{id}', [MarketPredictionController::class, 'update'])->name('market-prediction.update');
        Route::delete('market-prediction/{id}', [MarketPredictionController::class, 'destroy'])->name('market-prediction.destroy');

        // Inside your existing Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('basket', [BasketController::class, 'index'])->name('basket.index');
        Route::get('basket/create', [BasketController::class, 'create'])->name('basket.create');
        Route::post('basket', [BasketController::class, 'store'])->name('basket.store');
        Route::get('basket/{id}/edit', [BasketController::class, 'edit'])->name('basket.edit');
        Route::put('basket/{id}', [BasketController::class, 'update'])->name('basket.update');
        Route::delete('basket/{id}', [BasketController::class, 'destroy'])->name('basket.destroy');


    });
    



