<?php

namespace App\Http\Middleware;

use Closure;

class AuthenticateMitra
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $headers = $request->header('Authorization');
        $token = env('AUTH_TOKEN');
        if($token != $headers){
            return response()->json(['code' => 0 ,'message' => 'Invalid Authentication']);
        }

        return $next($request);
    }
}
