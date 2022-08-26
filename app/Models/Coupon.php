<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'count',
        'price',
        'type',
        'valid_before'
    ];

    public function orders() {
        return $this->hasMany(Order::class);
    }
}
