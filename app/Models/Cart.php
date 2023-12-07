<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable=[
        "productId",
        "userId",
        "qty"
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
   protected $appends = ['total'];

    public function getTotalAttribute()
    {
        return $this->qty * $this->product->price;
    }

    public function decrease()
    {
        $this->product()->update([
            'quantityInStock'=> $this->product->quantityInStock - $this->qty

        ]);
    }
}
