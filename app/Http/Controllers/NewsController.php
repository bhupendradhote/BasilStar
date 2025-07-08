<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function showDetail(Request $request)
    {
        // You can access the uuid from the request query parameters like this:
        $uuid = $request->query('uuid');


        return view('news_detail'); // Render the news_detail.blade.php view
    }
}