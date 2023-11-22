<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\vendorRequest;
use Illuminate\Http\Request;
use App\Models\Product;
class vendorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $input=product::all();
        return response()->json(['data'=>$input]);
    }

    public function showByCategory($category)
    {
     $products= product::where('category_id',$category)->get()->load('category');
     return response()->json(['data'=>$products]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(vendorRequest $request)
    {
        $input=$request->validated();
        product::create($input);
        return response()->json(["Message"=>'product is added successfuly']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product =product::findOrFail($id);
        return response()->json(["data"=>$product]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(vendorRequest $request, string $id)
    {
      $input = $request->validated();
      $product= Product::findOrFail($id);
      $product->update($input);
      return response()->json(["message"=>"product is updated successfuly"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product =product::findOrFail($id);
        $product->delete();
        return response()->json(["Message"=>'product is deleted successfuly']);
    }
}
