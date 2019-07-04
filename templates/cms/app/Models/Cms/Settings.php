<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $table = 'settings';
    public $timestamps = false;

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
