<?php

namespace App\Http\Controllers;

use App\Http\Requests\role\StoreRoleRequest;
use App\Http\Requests\role\UpdateRoleRequest;
use App\Models\Role;
use App\Http\Resources\RoleResource;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Role::class, 'role');
    }

    public function index()
    {
        return new RoleResource(200, 'List data role', Role::paginate());
    }

    public function store(StoreRoleRequest $request)
    {
        $role = Role::create([
            'name'     => $request->name,
        ]);
        return new RoleResource(201, 'Create data role', $role);
    }

    public function show(Role $role)
    {
        return new RoleResource(200, 'Detail data role', $role);
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role->update([
            'name'     => $request->name,
        ]);
        return new RoleResource(200, 'Update data role', $role);
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return new RoleResource(200, 'Delete data role', null);
    }
}
