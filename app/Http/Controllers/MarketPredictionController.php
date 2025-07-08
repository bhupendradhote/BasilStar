<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MarketPrediction;

class MarketPredictionController extends Controller
{

    public function index()
    {
        // $prediction = MarketPrediction::latest()->first();
        $predictions = MarketPrediction::latest()->get();
        return view('admin.market_prediction.index', compact('predictions'));
    }

    
    public function create()
    {
        return view('admin.market_prediction.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'required|string',
            'range' => 'nullable|string',
            'market_sentiment' => 'nullable|string',
            'global_cues' => 'nullable|string',
            'volatility_alert' => 'nullable|string',
            'support_levels' => 'nullable|string',
            'resistance_levels' => 'nullable|string',
        ]);
    
        $imagePath = null;
    
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $destination = public_path('uploads/market_predictions');
    
            // Create directory if not exists
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }
    
            $file->move($destination, $filename);
    
            $imagePath = 'uploads/market_predictions/' . $filename;
        }
    
        MarketPrediction::create([
            'title' => $request->title,
            'image_url' => $imagePath ? $imagePath : null,
            'description' => $request->description,
            'range' => $request->range,
            'market_sentiment' => $request->market_sentiment,
            'global_cues' => $request->global_cues,
            'volatility_alert' => $request->volatility_alert,
            'support_levels' => $request->support_levels,
            'resistance_levels' => $request->resistance_levels,
        ]);
    
        return redirect()->back()->with('success', 'Market prediction saved successfully.');
        }
    
        public function edit($id)
        {
            $prediction = MarketPrediction::findOrFail($id);
            return view('admin.market_prediction.edit', compact('prediction'));
        }
        
        public function update(Request $request, $id)
        {
            $request->validate([
                'title' => 'required|string|max:255',
                'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'description' => 'required|string',
                'range' => 'nullable|string',
                'market_sentiment' => 'nullable|string',
                'global_cues' => 'nullable|string',
                'volatility_alert' => 'nullable|string',
                'support_levels' => 'nullable|string',
                'resistance_levels' => 'nullable|string',
            ]);
        
            $prediction = MarketPrediction::findOrFail($id);
        
            if ($request->hasFile('image_file')) {
                $file = $request->file('image_file');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = public_path('uploads/market_predictions');
                if (!file_exists($path)) mkdir($path, 0755, true);
                $file->move($path, $filename);
                $prediction->image_url = 'uploads/market_predictions/' . $filename;
            }
        
            $prediction->update([
                'title' => $request->title,
                'description' => $request->description,
                'range' => $request->range,
                'market_sentiment' => $request->market_sentiment,
                'global_cues' => $request->global_cues,
                'volatility_alert' => $request->volatility_alert,
                'support_levels' => $request->support_levels,
                'resistance_levels' => $request->resistance_levels,
            ]);
        
            return redirect()->route('admin.market-prediction.index')->with('success', 'Updated successfully.');
            }
        
        public function destroy($id)
        {
            $prediction = MarketPrediction::findOrFail($id);
            $prediction->delete();
            return redirect()->back()->with('success', 'Deleted successfully.');
        }

}
