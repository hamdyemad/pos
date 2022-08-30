<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class ApprovalOrder extends Model
{
    protected $table = 'approval_histories';
    protected $fillable = [
        'user_id',
        'order_id',
        'approved'
    ];


    public function user() {
        return $this->belongsTo(User::class);
    }
}
