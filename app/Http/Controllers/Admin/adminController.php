<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class adminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    { // show all vendors
        $vendors=Vendor::all();
        return response()->json(["data"=>$vendors]);
    }


    public function store(Request $request)
    {  //add new vendor
        $input=$request->validate([
            'name'=>['require'],
            'email'=>['required'],
            'password'=>['required',Hash::make('password')],
        ]);
        Vendor::create($input);
        return response()->json(["message"=>"vendor is added successfuly"]);
    }


    public function show(string $id)
    { // show specified vendor
        $vendor=Vendor::findOrFail($id);
        return response()->json(["vendor"=>$vendor]);
    }


    public function update(Request $request, string $id)
    { //update vendor
        $input=$request->validate([
            'name'=>['require'],
            'email'=>['required'],
            'password'=>['required',Hash::make('password')],
        ]);
        $vendor=Vendor::findOrFail($id);
        $vendor->update($input);
        return response()->json(["message"=>"vendor is updated successfuly"]);
    }


    public function destroy(string $id)
    {    //delete vendor
        $vendor=Vendor::findOrFail($id);
        $vendor->delete();
        return response()->json(["message"=>"vendor is deleted successfuly"]);
    }
}
