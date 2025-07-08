<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model{
    use HasFactory;
    protected $fillable = [
        'payment_id',
        'user_id',
        'amount',
        'email',
        'order_id',
        'be_event_id',
        'status',
    ];
}