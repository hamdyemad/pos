<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BranchProductQty extends Model
{
    //
    protected $table = 'branches_products_qty';
    protected $fillable = [
        'branch_id',
        'product_id',
        'variant_id',
        'qty'
    ];


    public function branch() {
        return $this->belongsTo(Branch::class);
    }
}
