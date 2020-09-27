<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\UserNotDefinedException;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('jwt', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->claims(['email' => $credentials['email']])->attempt($credentials)) {
            return response()->json(['error' => 'unaa'], 401);
        }

        return response()->json(['token' => $token], 200);
        // return $this->respondWithToken($token);
    }

    public function payload(){
        return auth()->payload();
    }
}

