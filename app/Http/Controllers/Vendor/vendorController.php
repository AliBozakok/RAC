<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\vendorRequest;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Vendor;
use App\Notifications\ProductQuantityNotification;

class vendorController extends Controller
{

    public function index()
    {
        $input=product::all();
        return response()->json(['data'=>$input]);
    }

    public function showByCategory($category)
    {
     $products= product::where('categoryId',$category)->get()->load('category');
     return response()->json(['data'=>$products]);

    }


    public function store(vendorRequest $request)
    {
        $input=$request->validated();
        product::create($input);
        return response()->json(["Message"=>'product is added successfuly']);
    }


    public function show(string $id)
    {
        $product =product::findOrFail($id);
        return response()->json(["data"=>$product]);
    }


    public function update(vendorRequest $request, string $id)
    {
      $input = $request->validated();
      $product= Product::findOrFail($id);
      $product->update($input);
      return response()->json(["message"=>"product is updated successfuly"]);
    }


    public function destroy(string $id)
    {
        $product =product::findOrFail($id);
        $product->delete();
        return response()->json(["Message"=>'product is deleted successfuly']);
    }
    public function __construct()
    {
        $this->middleware('auth:vendor', ['except' => ['login']]);
    }


    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth('vendor')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function me()
    {
        return response()->json(auth('vendor')->user());
    }



    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('vendor')->factory()->getTTL() * 60
        ]);
    }

  /*  public function sendNotification(string $productId)
   {
    $product = product::findOrFail($productId);

    if ($product->quantity == 2) {
        $vendor = Vendor::findOrFail($product->vendor_id);
        $vendor->notify(new ProductQuantityNotification($product));
    }

    return response()->json(['message' => 'Notification sent successfully']);

    }*/

}
