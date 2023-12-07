<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\orderResource;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
Use App\Models\Cart;
class orderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::where('userId',auth()->id())->with('OrderItem.Product')->get();
        return orderResource::collection($orders);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input  = $request->validate([
            'address' => 'required',
            'phoneNumber' => 'required',
        ]);


        $orderId  = Order::latest()->first();

        if($orderId == null){
            $orderId = 1;
        }else{
            $orderId = $orderId->id +1;
        }

        $cartItems = Cart::where('userId',auth()->id())->get();

        $orderTotal = 0;
        foreach($cartItems as $item){
            OrderItem::create([
                'orderId'=>$orderId,
                'productId'=>$item->productId,
                'qty'=>$item->qty
            ]);
            $item->decrease();
            $orderTotal = $orderTotal + $item->total;
            $item->delete();
        }

        Order::create([
            'userId'=>auth()->id(),
            'total' => $orderTotal,
            'address' => $input['address'],
            'phoneNumber' =>$input['phoneNumber']
        ]);

        return response()->json([
            'message'=>'order is created'
        ]);
    }


}
