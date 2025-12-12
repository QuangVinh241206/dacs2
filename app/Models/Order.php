<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'order_number',
        'customer_name',
        'customer_phone',
        'customer_address',
        'total_amount',
        'subtotal',
        'discount_amount',
        'voucher_id',
        'payment_method',
        'status',
        'payment_id',
        'paid_at',
        'order_date',
        'total_price',
        'shipping_address',
        'order_status',
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
