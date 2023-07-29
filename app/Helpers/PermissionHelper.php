<?php

namespace App\Helpers;

use App\Models\User;
use App\Enums\Permission;

class PermissionHelper
{
    public static function verify(User $user, Permission $use, $user_id)
    {
        foreach ($user->roles as $role) {
            if (in_array(Permission::ManageAll->value, $role->permission)) return true;
            else if (in_array($use->value, $role->permission)) return true;
            else if (in_array(round($use->value/100)*100, $role->permission)) return true;
            else if ($user->id === $user_id) return true;
        }
        return false;
    }
}
