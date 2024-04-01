<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_amount',
        'items',
        'delivery_address',
        'payment_method',
    ];
    protected $casts = [
        'items' => 'json',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}