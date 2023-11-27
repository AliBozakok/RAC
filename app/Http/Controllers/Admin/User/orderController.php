<?php

namespace App\Http\Controllers\Admin\User;

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
        $orders = Order::where('user_id',auth()->id())->with('OrderItem.Product')->get();
        return orderResource::collection($orders);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input  = $request->validate([
            'address' => 'required',
            'phone_number' => 'required',
        ]);


        $orderId  = Order::latest()->first();

        if($orderId == null){
            $orderId = 1;
        }else{
            $orderId = $orderId->id +1;
        }

        $cartItems = Cart::where('user_id',auth()->id())->get();

        $orderTotal = 0;
        foreach($cartItems as $item){
            OrderItem::create([
                'order_id'=>$orderId,
                'product_id'=>$item->product_id,
                'qty'=>$item->qty
            ]);
            $item->decrease();
            $orderTotal = $orderTotal + $item->total;
            $item->delete();
        }

        Order::create([
            'user_id'=>auth()->id(),
            'total' => $orderTotal,
            'address' => $input['address'],
            'phone_number' =>$input['phone_number']
        ]);

        return response()->json([
            'message'=>'order is created'
        ]);
    }


}
