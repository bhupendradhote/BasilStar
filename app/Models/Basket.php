<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Basket extends Model
{
    protected $fillable = ['basket_type'];

    public function stocks()
    {
        return $this->hasMany(BasketStock::class);
    }


}
