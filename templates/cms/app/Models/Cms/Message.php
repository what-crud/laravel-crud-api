<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'email',
        'sender',
        'content',
        'active'
    ];
    
    public static $validator = [
        'email' => 'required|string',
        'sender' => 'required|string',
        'content' => 'required|string|max:5000',
        'active' => 'boolean',
    ];
}
