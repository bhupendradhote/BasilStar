<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Strategy;

class StrategyController extends Controller
{
     public function index()
    {
        $strategies = Strategy::latest()->get();
        return view('admin.Strategy.index', compact('strategies'));
    }
    
    public function create()
    {
        return view('admin.Strategy.create'); 
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $destination = public_path('uploads/market_predictions'); // ✅ use same folder

            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            $file->move($destination, $filename);
            $imagePath = 'uploads/market_predictions/' . $filename;
        }

        Strategy::create([
            'title' => $request->title,
            'description' => $request->description,
            'image_url' => $imagePath,
        ]);

        return redirect()->back()->with('success', 'Strategy saved successfully.');
    }
    
    public function edit($id)
{
    $strategy = Strategy::findOrFail($id);
    return view('admin.Strategy.edit', compact('strategy'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $strategy = Strategy::findOrFail($id);

    if ($request->hasFile('image_file')) {
        $file = $request->file('image_file');
        $filename = time() . '_' . $file->getClientOriginalName();
        $destination = public_path('uploads/market_predictions');

        if (!file_exists($destination)) {
            mkdir($destination, 0755, true);
        }

        $file->move($destination, $filename);
        $strategy->image_url = 'uploads/market_predictions/' . $filename;
    }

    $strategy->title = $request->title;
    $strategy->description = $request->description;
    $strategy->save();

    return redirect()->route('admin.strategy.index')->with('success', 'Strategy updated successfully.');
}

public function destroy($id)
{
    $strategy = Strategy::findOrFail($id);
    $strategy->delete();

    return redirect()->back()->with('success', 'Strategy deleted successfully.');
}



}
