<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $table = 'products_variations';
    protected $fillable = ['type', 'variant', 'barcode', 'count', 'product_id'];


    public function price() {
        return $this->hasOne(ProductVariantPrice::class, 'variant_id');
    }

    public function currenctPriceOfVariant() {
        return $this->hasOne(ProductVariantPrice::class, 'variant_id');
    }

}
