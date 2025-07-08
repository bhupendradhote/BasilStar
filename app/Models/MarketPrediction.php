<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarketPrediction extends Model
{
    protected $fillable = [
    'title',
    'image_url',
    'description',
    'range',
    'market_sentiment',
    'global_cues',
    'volatility_alert',
    'support_levels',
    'resistance_levels',
];

}
