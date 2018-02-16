<?php

namespace App\Models\Crm;

use Illuminate\Database\Eloquent\Model;

class CompanyType extends Model
{
    protected $fillable = ['name', 'code', 'active'];
}
