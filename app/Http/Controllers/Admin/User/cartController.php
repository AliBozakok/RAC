<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use App\Http\Resources\cartResource;
class cartController extends Controller
{

    public function index()
    {
        //show user cart
       $cartItem= Cart::where('userId',auth()->id())->get();
       return cartResource::collection($cartItem);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
          // store products in user cart
        $input = $request->validate([
            'product_id'=>'required',
            'qty'=>['nullable','numeric']
        ]);

        $item = Cart::where('product_id',$input['product_id'])
        ->where('user_id',auth()->id())->first();

        if(!$item){
            $input['user_id'] = auth()->id();
            Cart::create($input);
            return response()->json([
                'message'=>'item added'
            ]);
        }

        $cartQty = $item->qty;

        if($cartQty >= $item->product->qty)
        {
            return response()->json([
                'message'=>'quantity not available'
            ]);
        }
        $item->qty = $cartQty+1;
        $item->save();
        return response()->json([
            'message'=>'quantity updated'
        ]);
    }

    public function update(Request $request, string $id)
    {   // increase qty of specific product
        $input = $request->validate([
            'qty'=>['required','numeric']
        ]);

        $item = Cart::where('product_id',$id)
        ->where('user_id',auth()->id())->firstOrFail();

        $cartQty = $item->qty + $request->qty;

        // dd($cartQty);
        if($cartQty > $item->product->quantityInStock)
        {
            return response()->json([
                'message'=>'quantity not available'
            ]);
        }
        $item->qty = $cartQty;
        $item->save();
        return response()->json([
            'message'=>'quantity updated'
        ]);
    }
    public function remove(Request $request,string $id)
    {
        //decrease qty specific product
        $input = $request->validate([
            'qty'=>['required','numeric']
        ]);

        $item = Cart::where('product_id',$id)
        ->where('user_id',auth()->id())->firstOrFail();

        $cartQty = $item->qty - $request->qty;

        if($cartQty <= 1)
        {
            $item->qty = 1;
            $item->save();
            return response()->json([
                'message'=>'the minimum is 1'
            ]);
        }
        $item->qty = $cartQty;
        $item->save();
        return response()->json([
            'message'=>'quantity updated'
        ]);
    }

    public function destroy(string $id)
    {   // delete product from user cart
        $item = Cart::where('product_id',$id)
        ->where('user_id',auth()->id())->firstOrFail();
        $item->delete();
        return response()->json([
            'message'=>'item deleted'
        ]);

    }
}
