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
    'vendorId'];

    public function category()
    {
        return $this->belongsTo(category::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function notification()
    {
        if($this->quantityInStock<2)
        return response()->json(["message"=>"the product".$this->title." is out of stock"]);
    }

}
