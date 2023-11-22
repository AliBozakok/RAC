<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
class productsOfUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // show all active products
        $products = Product::getActive()->get();

        return response()->json([
            'data'=>$products
        ]);
    }


    public function show(string $id)
    {
        // show specific product
        $product= product::findOrFail($id);
        return response()->json(['data'=>$product]);
    }


}
