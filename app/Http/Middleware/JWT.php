<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;

class JWT
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
        // try {

        //     if (! $user = JWTAuth::parseToken()->authenticate()) {
        //         return response()->json(['user_not_found'], 404);
        //     }
    
        // } catch (TokenExpiredException $e) {
    
        //     return response()->json(['token_expired'], '400');
    
        // } catch (TokenInvalidException $e) {
    
        //     return response()->json([$e], '400');
    
        // } catch (JWTException $e) {
    
        //     return response()->json(['token_absent'], '400');
    
        // }
        JWTAuth::parseToken()->authenticate();
        return $next($request);
    }
}
