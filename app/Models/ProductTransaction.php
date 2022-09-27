<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductTransaction extends Model
{
    protected $table = 'product_transactions';
    protected $fillable = [
        'branch_id',
        'main_status_id',
        'branch_status_id',
    ];

    public function branch_status() {
        return $this->belongsTo(ProductTransactionStatus::class);
    }

    public function main_status() {
        return $this->belongsTo(ProductTransactionStatus::class);
    }

    public function branch() {
        return $this->belongsTo(Branch::class);
    }

    public function items() {
        return $this->hasMany(ProductTransactionItem::class, 'transaction_id');
    }
}
