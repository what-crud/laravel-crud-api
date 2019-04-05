<?php

namespace App\Models\Crm;

use Illuminate\Database\Eloquent\Model;
use App\Models\Crm\Position;
use App\Models\Crm\Language;
use App\Models\Crm\Sex;
use App\Models\Crm\PersonComment;

class Person extends Model
{
    protected $fillable = [
        'firstname',
        'lastname',
        'distinction',
        'sex_id',
        'language_id',
        'email',
        'phone',
        'active',
    ];
    protected $appends = ['fullname'];
    
    public function getFullnameAttribute()
    {
        return $this->lastname." ".$this->firstname;
    }
    
    public static $validator = [
        'firstname' => 'required|string',
        'lastname' => 'required|string',
        'distinction' => 'string|nullable',
        'sex_id' => 'required|exists:sexes,id',
        'language_id' => 'required|exists:languages,id',
        'email' => 'string|nullable',
        'phone' => 'string|nullable',
        'active' => 'boolean'
    ];

    public function positions()
    {
        return $this->hasMany(Position::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
    public function sex()
    {
        return $this->belongsTo(Sex::class);
    }
    public function comments()
    {
        return $this->hasMany(PersonComment::class)->orderBy('id', 'desc');
    }
}
