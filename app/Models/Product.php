<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
    'title',
    'description',
    'imageUrl',
    'price',
    'quantityInStock',
    'categoryId',
    ];

    protected $appends=['is_active'];

    public function getIsActiveAttribute()
    {
     return $this->quantity !=0;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /*public function carts()
    {
        return $this->hasMany(Cart::class);
    }
   /* public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }*/

    public function notification()
    {
        if($this->quantityInStock<2)
        return response()->json(["message"=>"the product".$this->title." is out of stock"]);
    }
    public function scopeGetActive()
    {
        return $this->where('quantityInStock','!=',0);
    }

}
