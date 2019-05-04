<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\UserPermission;

class Permission extends Model
{
    protected $fillable = [
        'name',
        'code',
        'active',
        'path'
    ];
    
    public static $validator = [
        'name' => 'required|string',
        'code' => 'required|string|max:10',
        'active' => 'boolean',
        'path' => 'required|string|max:10'
    ];
    
    public function permissionUsers()
    {
        return $this->hasMany(UserPermission::class);
    }
}
