<?php

namespace App\Models\Admin;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Admin\UserPermission;
use App\Models\Admin\UserType;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'initial_password',
        'user_type_id',
        'active'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    
    public static $validator = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|max:255|unique:users,email',
        'user_type_id' => 'exists:user_types,id',
        'active' => 'nullable',
    ];

    public function userPermissions()
    {
        return $this->hasMany(UserPermission::class);
    }

    public function userType()
    {
        return $this->belongsTo(UserType::class, 'user_type_id');
    }
}
