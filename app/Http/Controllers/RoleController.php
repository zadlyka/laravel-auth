<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Http\Resources\Role\RoleResource;
use App\Http\Resources\Role\RoleCollection;
use App\Http\Requests\role\StoreRoleRequest;
use App\Http\Requests\role\UpdateRoleRequest;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Role::class, 'role');
    }

    public function index()
    {
        return new RoleCollection(Role::paginate(), 200, 'List data role');
    }

    public function store(StoreRoleRequest $request)
    {
        $role = Role::create([
            'name'     => $request->name,
            'permission' => $request->permission,
        ]);
        return new RoleResource($role, 200, 'Create data role');
    }

    public function show(Role $role)
    {
        return new RoleResource($role, 200, 'Detail data role');
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role->update([
            'name'     => $request->name,
            'permission' => $request->permission,
        ]);
        return new RoleResource($role, 200, 'Update data role');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return new RoleResource($role, 200, 'Delete data role');
    }
}
