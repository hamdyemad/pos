<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'address',
        'phone',
        'phone2',
        'email',
        'type'
    ];


    public function orders() {
        return $this->hasMany(Order::class);
    }
}
