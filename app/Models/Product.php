<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name','count','sku','photos', 'barcode','description','active','viewed_number'
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

    public function branch_variants($ids) {
        return $this->hasMany(ProductVariant::class, 'product_id')->whereIn('id', $ids);

    }

    public function price_of_currency() {
        return $this->hasOne(ProductPrice::class, 'product_id');
    }

    public function branches_qty() {
        return $this->hasMany(BranchProductQty::class, 'product_id')->orderBy('branch_id');
    }
}
