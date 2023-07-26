<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\UserCollection;
use App\Http\Requests\user\StoreUserRequest;
use App\Http\Requests\user\UpdateUserRequest;

class UserController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

    public function index()
    {
        return new UserCollection(User::paginate(), 200, 'List data user');
    }

    public function store(StoreUserRequest $request)
    {
        $hash = $request->password ? Hash::make($request->password) : Hash::make('not-set');
        $user = User::create([
            'name'     => $request->name,
            'email'   => $request->email,
            'password' => $hash
        ]);
        foreach ($request->roles as $role) {
            UserRole::create([
                'user_id' => $user->id,
                'role_id' => $role,
            ]);
        }
        return new UserResource($user, 201, 'Create data user');
    }

    public function show(User $user)
    {
        return new UserResource($user, 200, 'Detail data user');
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update([
            'name'     => $request->name,
            'email'   => $request->email,
        ]);
        if ($request->roles) {
            UserRole::where('user_id', $user->id)->forceDelete();
            foreach ($request->roles as $role) {
                UserRole::create([
                    'user_id' => $user->id,
                    'role_id' => $role,
                ]);
            }
        }
        return new UserResource($user, 200, 'Update data user');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return new UserResource($user, 200, 'Delete data user');
    }
}
