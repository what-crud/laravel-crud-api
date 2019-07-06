<?php

namespace App\Models\Demo;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['name', 'description', 'active'];
    
    public static $validator = [
        'name' => 'required|string|max:200',
        'description' => 'string|max:500|nullable',
        'active' => 'boolean'
    ];
}
