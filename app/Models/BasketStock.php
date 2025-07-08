<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BasketStock extends Model
{
    protected $fillable = ['basket_id', 'symbol', 'buy_price', 'target_price', 'stop_loss'];

    public function basket()
    {
        return $this->belongsTo(Basket::class);
    }
    
    
    
}
