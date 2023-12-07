<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
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
            'name'=>'required',
            'email'=>'required',
            'password'=>'required'
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
            'name'=>'required',
            'email'=>'required',
            'password'=>'required',
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
    public function Registeration(Request $request)
    {
         //validation
        $input= $request->validate(['name'=>['required']
        ,'email'=>['required'],'phoneNumber'=>['required'],'password'=>['required']]);
         // chagne the password to hash::make
        $user= Admin::where('email',$request->email)->first();
        if(!$user){
            Admin::create($input);
            return response()->json(['message'=>'Registeration is added successfully' ]) ;
        }
        return response()->json(['message'=>'user is found' ]) ;
    }


    public function __construct()
    {
        $this->middleware('auth:admin', ['except' => ['login','Registeration']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth('admin')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth('admin')->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */


    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('admin')->factory()->getTTL() * 60
        ]);
    }
}
