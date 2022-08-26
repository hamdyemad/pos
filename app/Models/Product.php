<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name','count','photos','description','active','viewed_number'
    ];

    public function prices() {
        return $this->hasMany(ProductPrice::class, 'product_id');
    }

    public function categories() {
        return $this->belongsToMany(Category::class, 'categories_products', 'product_id')->withTimestamps();
    }

    public function variants() {
        return $this->hasMany(ProductVariant::class, 'product_id');
    }

    public function price_of_currency() {
        return $this->hasOne(ProductPrice::class, 'product_id');
    }
}
