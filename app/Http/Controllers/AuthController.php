<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\Auth\AuthResource;
use App\Http\Requests\Auth\RegisterRequest;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password'))
        ]);

        
        foreach ($request->input('roles') as $role) {
            UserRole::create([
                'user_id' => $user->id,
                'role_id' => $role,
            ]);
        }

        $token = auth('api')->login($user);
        return new AuthResource([
            'user' => $user,
            'access_token' => $token
        ], Response::HTTP_CREATED, 'Register user');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $token = auth('api')->attempt($credentials);
        if (!$token) {
            abort(Response::HTTP_UNAUTHORIZED, 'Unauthorized');
        }

        return new AuthResource([
            'access_token' => $token,
            'token_type' => 'Bearer'
        ], Response::HTTP_OK, 'Login success');
    }

    public function refresh()
    {
        $token = auth('api')->refresh();
        return new AuthResource([
            'access_token' => $token,
            'token_type' => 'Bearer'
        ], Response::HTTP_OK, 'Login success');
    }

    public function logout()
    {
        auth('api')->logout();
        return new AuthResource(null, Response::HTTP_OK, 'Logout success');
    }
}
