<?php

namespace App\Models\Crm;

use Illuminate\Database\Eloquent\Model;
use App\Models\Crm\UserPermission;

class Permission extends Model
{
    protected $fillable = [
        'name', 'code', 'active',
    ];
    
    public function permissionUsers()
    {
        return $this->hasMany(UserPermission::class);
    }
}
