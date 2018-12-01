<?php

namespace App\Libraries;

use App\Models\Crm\UserPermission;
use App\Models\Crm\Permission;
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