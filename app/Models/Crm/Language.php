<?php

namespace App\Models\Crm;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $fillable = ['name', 'priority'];
    
    public static $validator = [
    ];

    public $timestamps = false;
    
    public function people()
    {
        return $this->hasMany(Person::class);
    }
}
