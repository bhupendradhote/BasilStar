<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TradeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function liveChart()
    {
        return view('../BasilTrade/liveChart');
    }

    public function marketPrediction()
    {
        return view('../BasilTrade/marketPrediction');
    }

    public function marketPredictionDetails()
    {
        return view('../BasilTrade/marketPredictionDetails');
    }

    public function chatbot()
    {
        return view('../BasilTrade/chatbot');
    }
}