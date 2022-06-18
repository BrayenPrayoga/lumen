<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\Models\User;
use App\Helper;
use App\Constants\ErrorCode as EC;
use App\Constants\ErrorMessage as EM;

class AuthController extends Controller
{
    public function __construct()
    {
        if(Auth::guard('internal')->check()){
            $this->middleware('auth:internal', ['except' => ['login', 'refresh', 'logout','login_pengguna']]);
        }else{
            $this->middleware('auth:pengguna', ['except' => ['login', 'refresh', 'logout','login_pengguna']]);
        }
    }
    /**
     * Get a JWT via given credentials.
     *
     * @param  Request  $request
     * @return Response
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only(['email', 'password']);

        if(Auth::guard('internal')->check()){
            $guards = Auth::guard('internal')->attempt($credentials);
        }else{
            $guards = Auth::guard('pengguna')->attempt($credentials);
        }

        if (!$token = $guards) {
            return response()->json(['message' => 'Unauthorized'], 401);
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
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        if(Auth::guard('internal')->check()){
            $user = Auth::guard('internal')->user();
        }else{
            $user = Auth::guard('pengguna')->user();
        }

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'user' => $user,
            'expires_in' => auth()->factory()->getTTL() * 60 * 24
        ]);
    }

    public function afterLogin(){
        if(Auth::guard('internal')->check()){
            return response()->json(['data' => Auth::guard('internal')->user()]);
        }else{
            return response()->json(['data' => Auth::guard('pengguna')->user()]);
        }
    }
}