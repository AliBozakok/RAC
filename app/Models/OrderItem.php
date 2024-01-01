<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    protected $fillable=[
        'productId',
        'orderId',
        'qty'];
        public function product()
    {
        return $this->belongsTo(Product::class,'productId','id');
    }
}
