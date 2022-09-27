<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductTransactionItem extends Model
{
    protected $table = 'product_transaction_items';
    protected $fillable = [
        'transaction_id',
        'product_id',
        'variant_id',
        'qty',
        'main_accepted',
        'main_refused',
        'branch_accepted',
        'branch_refused',
        'reason',
        'notes',
    ];

    public function status() {
        return $this->belongsTo(ProductTransactionStatus::class);
    }

    public function transaction() {
        return $this->belongsTo(ProductTransaction::class);
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }
    public function variant() {
        return $this->belongsTo(ProductVariant::class);
    }
}
