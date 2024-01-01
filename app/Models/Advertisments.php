<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advertisments extends Model
{
    use HasFactory;
    protected $fillable =[
        "title",
        "descreption",
        "imgUrl",
        "discount",
        "previousPrice",
        "priceNow"
    ];

}
