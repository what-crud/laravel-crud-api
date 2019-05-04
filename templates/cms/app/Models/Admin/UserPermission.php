<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\User;
use App\Models\Admin\Permission;

class UserPermission extends Model
{
    protected $fillable = [
        'user_id',
        'permission_id'
    ];
    
    public static $validator = [
        'user_id' => 'required|exists:users,id',
        'permission_id' => 'required|exists:permissions,id',
        'active' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }
}
