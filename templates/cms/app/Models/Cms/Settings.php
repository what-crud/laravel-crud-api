<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $table = 'settings';
    public $timestamps = false;

    protected $fillable = [
        'type',
        'name',
        'value'
    ];
    
    public static $validator = [
        'type' => 'required|string|max:100',
        'name' => 'required|string',
        'value' => 'required|string|max:5000'
    ];
}
