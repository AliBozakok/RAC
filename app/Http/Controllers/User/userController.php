<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use App\Models\Order;
class userController extends Controller
{


    public function Registeration(Request $request)
    {
         //validation
        $input= $request->validate(['name'=>['required']
        ,'email'=>['required'],'password'=>['required'],'imageUrl'=>['required']]);
        $user= User::where('email',$request->email)->first();
        if(!$user){
            User::create($request->all());
            return response()->json(['message'=>'Registeration is added successfully' ]) ;
        }
        return response()->json(['message'=>'user is found' ]) ;
    }


    public function __construct()
    {
        $this->middleware('auth:user', ['except' => ['login','Registeration','forgotPassword','resetPassword']]);
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
    public function forgotPassword(Request $request)
  {
            $request->validate(['email' => 'required|email']);

            $otp = rand(1000,9999);
            $user = User::where('email', $request->email)->first();
            $user->otp = $otp;
            $user->save();

             return response()->json([ 'status' => 'success' , 'otp' => $otp ]);
}

public function resetPassword(Request $request) {

    // Validate OTP


           $user = User::where('email', $request->email)
                 ->where('otp', $request->otp)
                 ->first();

    // Reset password

            $user->password = Hash::make($request->newPassword);
            $user->save();

    // Clear OTP

            $user->otp = null;
            $user->save();

            return response()->json(['status' => 'success']);

  }


}
