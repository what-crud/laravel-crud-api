<?php

namespace App\Models\Crm;

use Illuminate\Database\Eloquent\Model;

class CompanyType extends Model
{
    protected $fillable = ['name', 'code', 'active'];
    
    public static $validator = [
        'name' => 'required|string|max:200',
        'code' => 'required|string|size:3',
        'active' => 'boolean'
    ];
}
