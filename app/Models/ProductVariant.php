<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $fillable = ['product_id','size','color','price','stock','sku'];

    public function product() { return $this->belongsTo(Product::class); }
}
