<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use App\Enums\Permission;
use App\Helpers\PermissionHelper;
use Illuminate\Auth\Access\Response;

class RolePolicy
{
    public function viewAny(User $user): bool
    {
        return PermissionHelper::verify($user, Permission::ReadRole, null);
    }

    public function view(User $user, Role $role): bool
    {
        return PermissionHelper::verify($user, Permission::ReadRole, null);
    }

    public function create(User $user): bool
    {
        return PermissionHelper::verify($user, Permission::CreateRole, null);
    }

    public function update(User $user, Role $role): bool
    {
        return PermissionHelper::verify($user, Permission::UpdateRole, null);
    }

    public function delete(User $user, Role $role): bool
    {
        return PermissionHelper::verify($user, Permission::DeleteRole, null);
    }

    public function restore(User $user, Role $role): bool
    {
        return PermissionHelper::verify($user, Permission::UpdateRole, null);
    }

    public function forceDelete(User $user, Role $role): bool
    {
        return PermissionHelper::verify($user, Permission::DeleteRole, null);
    }
}
