<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\auth\LoginRequest;
use App\Http\Resources\Auth\AuthResource;
use App\Http\Requests\auth\RegisterRequest;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        foreach ($request->roles as $role) {
            UserRole::create([
                'user_id' => $user->id,
                'role_id' => $role,
            ]);
        }
        $token = $user->createToken('auth_token')->plainTextToken;
        return new AuthResource([
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer'
        ], 201, 'Register success');
    }

    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                "status_code" => 401,
                'error' => 'Unauthorized'
            ], 401);
        }
        $user = User::where('email', $request->email)->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;
        return new AuthResource([
            'access_token' => $token,
            'token_type' => 'Bearer'
        ], 200, 'Login success');
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return new AuthResource(null, 200, 'Logout success');
    }
}
