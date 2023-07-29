<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\Role\RoleResource;
use App\Http\Resources\Role\RoleCollection;
use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use Symfony\Component\Console\Output\ConsoleOutput;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Role::class, 'role');
    }

    public function index(Request $request)
    {
        $limit =  $request->input('limit') ?? 10;
        $search =  $request->input('search');
        $sort = $request->input('sort');
        $filter = $request->input('filter');

        $role = Role::search($search)->sort($sort)->filter($filter)->paginate($limit);
        return new RoleCollection($role, Response::HTTP_OK, 'List data role');
    }

    public function store(StoreRoleRequest $request)
    {
        $out = new ConsoleOutput();
        $out->writeln($request);
        $role = Role::create([
            'name'     => $request->input('name'),
            'permission' => $request->input('permission'),
        ]);

        return new RoleResource($role, Response::HTTP_CREATED, 'Create data role');
    }

    public function show(Role $role)
    {
        return new RoleResource($role, Response::HTTP_OK, 'Detail data role');
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role->update([
            'name'     => $request->input('name'),
            'permission' => $request->input('permission'),
        ]);

        return new RoleResource($role, Response::HTTP_OK, 'Update data role');
    }

    public function destroy(Role $role)
    {
        $role->delete();

        return new RoleResource(null, Response::HTTP_OK, 'Delete data role');
    }
}
