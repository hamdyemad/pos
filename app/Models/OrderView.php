<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderView extends Model
{
    protected $table = 'orders_views';
    protected $fillable = ['order_id', 'user_id'];
}
