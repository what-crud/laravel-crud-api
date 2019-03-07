<?php

namespace App\Models\Crm;

use Illuminate\Database\Eloquent\Model;
use App\Models\Crm\Company;
use App\Models\Crm\Person;
use App\Models\Crm\PositionTask;

class Position extends Model
{
    protected $fillable = [
        'person_id',
        'company_id',
        'name',
        'phone',
        'phone_2',
        'phone_3',
        'email',
        'email_2',
        'comment',
        'active',
    ];
    
    public static $validator = [
        'person_id' => 'required|exists:people,id',
        'company_id' => 'required|exists:companies,id',
        'name' => 'string|max:255|nullable',
        'phone' => 'string|max:50|nullable',
        'phone_2' => 'string|max:50|nullable',
        'phone_3' => 'string|max:50|nullable',
        'email' => 'string|max:255|nullable',
        'email_2' => 'string|max:255|nullable',
        'comment' => 'string|max:500|nullable',
        'active' => 'boolean'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function positionTasks()
    {
        return $this->hasMany(PositionTask::class);
    }
}
