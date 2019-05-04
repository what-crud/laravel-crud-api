<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\User;

class UserType extends Model
{
    protected $fillable = [
        'name',
        'read',
        'insert',
        'update',
        'delete',
        'admin',
        'active',
    ];
    
    public static $validator = [
        'name' => 'required|string',
        'read' => 'required|boolean',
        'insert' => 'required|boolean',
        'update' => 'required|boolean',
        'delete' => 'required|boolean',
        'admin' => 'required|boolean',
        'active' => 'nullable|boolean',
    ];

    public function user()
    {
        return $this->hasMany(User::class, 'user_type_id');
    }
}
