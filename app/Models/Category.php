<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'photo', 'viewed_number', 'active'];

    public function products() {
        return $this->belongsToMany(Product::class, 'categories_products', 'category_id')->withTimestamps();
    }



    public function branches() {
        return $this->belongsToMany(Branch::class, 'branches_categories', 'category_id')->withTimestamps();
    }
}
