<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $fillable = ['name', 'order_type', 'paid', 'returned', 'under_collection','default_val', 'out_for_delivery'];
}
