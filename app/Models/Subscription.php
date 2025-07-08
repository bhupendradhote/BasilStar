<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;

class Subscription extends Model
{
    use HasFactory;
    
    protected $fillable = ['user_id', 'start_date', 'end_date'];

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'id');
    }
}
