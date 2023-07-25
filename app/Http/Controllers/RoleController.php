<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Resources\RoleResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\role\StoreRoleRequest;
use App\Http\Requests\role\UpdateRoleRequest;

class RoleController extends Controller
{
    public function index()
    {
        return new RoleResource(200, 'List data role', Role::paginate());
    }

    public function store(StoreRoleRequest $request)
    {
        $hash = $request->password ? Hash::make($request->password) : Hash::make('not-set');
        $role = Role::create([
            'name'     => $request->name,
            'email'   => $request->email,
            'password' => $hash
        ]);
        return new RoleResource(201, 'Create data role', $role);
    }


    public function show($id)
    {
        return new RoleResource(200, 'Detail data role', Role::findOrFail($id));
    }


    public function update(UpdateRoleRequest $request, $id)
    {
        $role = Role::find($id);
        $role->update([
            'name'     => $request->name,
            'email'   => $request->email,
        ]);
        return new RoleResource(200, 'Update data role', $role);
    }

    public function destroy($id)
    {

        $role = Role::find($id);
        $role->delete();
        return new RoleResource(200, 'Delete data role', null);
    }
}
