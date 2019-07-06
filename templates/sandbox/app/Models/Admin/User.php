<?php

namespace App\Models\Admin;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Admin\UserPermission;
use App\Models\Admin\UserType;

class User extends Authenticatable
{
    use Notifiable;

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function userType()
    {
        return $this->belongsTo(UserType::class, 'user_type_id');
    }
}
