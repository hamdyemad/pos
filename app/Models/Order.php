<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['type', 'branch_id', 'status_id','user_id',
    'coupon_id','bin_code','city_id','customer_id','paid','under_approve','payment_method',
    'notes','discount_type','total_discount', 'shipping','grand_total'];

    public function customer() {
        return $this->belongsTo(Customer::class);
    }
    public function coupon() {
        return $this->belongsTo(Coupon::class);
    }
    public function branch() {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
    public function order_details() {
        return $this->hasMany(OrderDetail::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function status() {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function city() {
        return $this->belongsTo(City::class, 'city_id');
    }

}

