<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\Auth\AuthResource;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $token = auth()->guard('api')->attempt($credentials);
        if (!$token) {
            abort(Response::HTTP_UNAUTHORIZED, 'Unauthorized');
        }

        return new AuthResource([
            'access_token' => $token,
            'token_type' => 'Bearer'
        ], Response::HTTP_OK, 'Login success');
    }
}
