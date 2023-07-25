<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\user\StoreUserRequest;
use App\Http\Requests\user\UpdateUserRequest;

class UserController extends Controller
{
    public function index()
    {
        return new UserResource(200, 'List data user', User::with(['roles'])->paginate());
    }

    public function store(StoreUserRequest $request)
    {
        $hash = $request->password ? Hash::make($request->password) : Hash::make('not-set');
        $user = User::create([
            'name'     => $request->name,
            'email'   => $request->email,
            'password' => $hash
        ]);
        return new UserResource(201, 'Create data user', $user);
    }


    public function show($id)
    {
        return new UserResource(200, 'Detail data user', User::with(['roles'])->findOrFail($id));
    }


    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::with(['roles'])->findOrFail($id);
        $user->update([
            'name'     => $request->name,
            'email'   => $request->email,
        ]);
        return new UserResource(200, 'Update data user', $user);
    }

    public function destroy($id)
    {

        $user = User::with(['roles'])->findOrFail($id);
        $user->delete();
        return new UserResource(200, 'Delete data user', null);
    }
}
