<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $fillable = [
        'code','discount_type','discount_value','start_date','end_date',
        'min_order_value','max_discount_value','is_active'
    ];

    public function orders() { return $this->hasMany(Order::class); }
}
