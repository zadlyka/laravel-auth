<?php

namespace App\Policies;

use App\Enums\Permission;
use App\Helpers\PermissionHelper;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return PermissionHelper::verify($user, Permission::ReadUser, null);
    }

    public function view(User $user, User $model): bool
    {
        return PermissionHelper::verify($user, Permission::ReadUser, $model->id);
    }

    public function create(User $user): bool
    {
        return PermissionHelper::verify($user, Permission::CreateUser, null);
    }

    public function update(User $user, User $model): bool
    {
        return PermissionHelper::verify($user, Permission::UpdateUser, $model->id);
    }

    public function delete(User $user, User $model): bool
    {
        return PermissionHelper::verify($user, Permission::DeleteUser, $model->id);
    }

    public function restore(User $user, User $model): bool
    {
        return PermissionHelper::verify($user, Permission::UpdateUser, $model->id);
    }

    public function forceDelete(User $user, User $model): bool
    {
        return PermissionHelper::verify($user, Permission::DeleteUser, $model->id);
    }
}
