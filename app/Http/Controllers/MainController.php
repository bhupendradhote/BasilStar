<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MarketPrediction;
use App\Models\Strategy;
use App\Models\Basket;
use App\Models\BasketStock;

class MainController extends Controller
{
    public function showOnAllMarketPredictions()
    {
        // $prediction = MarketPrediction::latest()->first();
        $predictions = MarketPrediction::latest()->get();
        return view('allMarketPredictions', compact('predictions'));
    }
    
    public function showOnAllStrategies()
    {
        // $prediction = MarketPrediction::latest()->first();
        $latestStrategies = Strategy::latest()->get();
        return view('allStrategies', compact('latestStrategies'));
    }
    
  public function showOnMainDashboard()
{
    $prediction = MarketPrediction::latest()->first();
    $latestStrategy = Strategy::latest()->first();

    $types = ['Intraday', 'Short Term', 'Long Term'];
    $baskets = [];

    foreach ($types as $type) {
        $basket = \App\Models\Basket::with('stocks')
            ->where('basket_type', $type)
            ->latest()
            ->first();

        if ($basket && $basket->stocks->count()) {
            $baskets[$type] = $basket;
        }
    }

    return view('analytics', compact('prediction', 'latestStrategy', 'baskets'));
}



    public function showAllBaskets(Request $request)
    {
        $sortBy = $request->get('sort_by', 'updated_at'); // Default sort by updated_at (date)
        $sortOrder = $request->get('sort_order', 'desc'); // Default order is descending (latest first)
        $filterType = $request->get('filter_type', 'all'); // Default filter is all types

        $query = Basket::with('stocks');

        if ($filterType !== 'all') {
            $query->where('basket_type', $filterType);
        }

        if ($sortBy === 'type') {
            $typeOrder = "FIELD(basket_type, 'Intraday', 'Short Term', 'Long Term')";

            if ($sortOrder === 'desc') {
                $typeOrder = "FIELD(basket_type, 'Long Term', 'Short Term', 'Intraday')";
            }

            $query->orderByRaw($typeOrder);

            $query->orderBy('updated_at', 'desc');
        } else { // Default or if 'sort_by' is 'updated_at' (date)
            $query->orderBy('updated_at', $sortOrder);

            $query->orderByRaw("FIELD(basket_type, 'Intraday', 'Short Term', 'Long Term') ASC");
        }

        $baskets = $query->get()->groupBy('basket_type');

        return view('allBaskets', compact('baskets', 'sortBy', 'sortOrder', 'filterType'));
    }






}
