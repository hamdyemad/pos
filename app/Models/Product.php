<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id','name','photos','description','active','viewed_number'
    ];

    public function prices() {
        return $this->hasMany(ProductPrice::class, 'product_id');
    }

    public function category() {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function variants() {
        return $this->hasMany(ProductVariant::class, 'product_id');
    }

    public function price_of_currency() {
        return $this->hasOne(ProductPrice::class, 'product_id');
    }

    public function current_price() {
        $currency = Currency::where('default', 1)->first();
        return $this->hasOne(ProductPrice::class, 'product_id')->where('currency_id', $currency->id);
    }
}
