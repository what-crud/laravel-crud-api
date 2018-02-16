<?php

namespace App\Models\Crm;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Crm\Permission;

class UserPermission extends Model
{
    protected $fillable = [
        'user_id',
        'permission_id'
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
