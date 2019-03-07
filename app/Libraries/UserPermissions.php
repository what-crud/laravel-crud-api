<?php

namespace App\Libraries;

use App\Models\Admin\UserPermission;
use App\Models\Admin\Permission;
use Auth;

trait UserPermissions
{
    public function getUserPermissions(){

        $userId = Auth::user()->id;
        $permissions = UserPermission
            ::where('user_id', '=', $userId)
            ->where('active', true)
            ->with('permission')
            ->get();
        $userPermissions = array();

        foreach($permissions as $item) {
            $userPermissions[] = $item->permission->code;
        }
        return $userPermissions;
    }

}