<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\BasketStock;
use Illuminate\Http\Request;

class BasketController extends Controller
{       
    
    
    public function index()
    {
        $baskets = Basket::with('stocks')->latest()->get();
        return view('admin.baskets.index', compact('baskets'));
    }

    public function create()
    {
        return view('admin.baskets.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'basket_type' => 'required|string',
            'basket.*.symbol' => 'required|string',
            'basket.*.buy_price' => 'required|numeric',
            'basket.*.target_price' => 'required|numeric',
            'basket.*.stop_loss' => 'required|numeric',
        ]);

        $basket = Basket::create([
            'basket_type' => $request->basket_type,
        ]);

        foreach ($request->basket as $stock) {
            $basket->stocks()->create($stock);
        }

        return redirect()->route('admin.basket.index')->with('success', 'Basket created successfully!');
    }

    public function edit($id)
    {
        $basket = Basket::with('stocks')->findOrFail($id);
        return view('admin.baskets.edit', compact('basket'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'basket_type' => 'required|string',
            'basket.*.symbol' => 'required|string',
            'basket.*.buy_price' => 'required|numeric',
            'basket.*.target_price' => 'required|numeric',
            'basket.*.stop_loss' => 'required|numeric',
        ]);

        $basket = Basket::findOrFail($id);
        $basket->update([
            'basket_type' => $request->basket_type,
        ]);

        // Remove old stocks
        $basket->stocks()->delete();

        // Add updated stocks
        foreach ($request->basket as $stock) {
            $basket->stocks()->create($stock);
        }

        return redirect()->route('admin.basket.index')->with('success', 'Basket updated successfully!');
    }

    public function destroy($id)
    {
        $basket = Basket::findOrFail($id);
        $basket->delete();

        return redirect()->route('admin.basket.index')->with('success', 'Basket deleted successfully!');
    }
}
