<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductTransactionStatus extends Model
{
    //
    protected $table = 'product_transactions_statuses';
    protected $fillable = [
        'name',
        'default_val',
        'accepted',
        'returned'
    ];
}
