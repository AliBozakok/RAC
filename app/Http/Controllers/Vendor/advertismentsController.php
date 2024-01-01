<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Advertisments;
use Illuminate\Http\Request;

class advertismentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Advertisments::all();
        return response()->json(["data"=> $data]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input= $request->validate([
            'title'=> ['required'],
            'description'=> ['required'],
            'imgUrl'=> ['required'],
            'discount'=> ['nullable','numeric'],
            'previousPrice'=> ['nullable','numeric'],
            'priceNow'=> ['nullable','numeric'],
        ]);

        Advertisments::create($input);
        return response()->json(["message"=> "Advertisment is added successfully"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
          $data= Advertisments::findOrFail($id);
          return response()->json(["data"=> $data]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $input= $request->validate([
            'title'=> ['required'],
            'description'=> ['required'],
            'imgUrl'=> ['required'],
            'discount'=> ['nullable','numeric'],
            'previousPrice'=> ['nullable','numeric'],
            'priceNow'=> ['nullable','numeric'],
        ]);

        $data= Advertisments::findOrFail($id);
        $data->update($input);
        return response()->json(["message"=> "Advertisment is updated successfully"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data= Advertisments::findOrFail($id);
        $data->delete();
        return response()->json(["message"=> "Advertisment is deleted successfully"]);
    }
}
