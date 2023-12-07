<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class userController extends Controller
{


    public function Registeration(Request $request)
    {
         //validation
        $input= $request->validate(['name'=>['required']
        ,'email'=>['required'],'password'=>['required'],'imgUrl'=>['required']]);
        $user= User::where('email',$request->email)->first();
        if(!$user){
            User::create($request->all());
            return response()->json(['message'=>'Registeration is added successfully' ]) ;
        }
        return response()->json(['message'=>'user is found' ]) ;
    }


    public function __construct()
    {
        $this->middleware('auth:user', ['except' => ['login','Registeration']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth('user')->attempt($credentials)) {
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
        return response()->json(auth('user')->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('user')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }


    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('user')->factory()->getTTL() * 60
        ]);
    }
}
