<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'order_date',
        'total_price',
        'voucher_id',
        'shipping_address',
        'order_status',
        'payment_method',
        'receiver_name',
        'receiver_phone'
    ];

    protected $casts = [
        'order_date' => 'datetime',
    ];

    public function details()
    {
        return $this->hasMany(OrderDetail::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }
}
