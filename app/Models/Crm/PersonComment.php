<?php

namespace App\Models\Crm;

use Illuminate\Database\Eloquent\Model;
use App\Models\Crm\Person;
use App\Models\Crm\PersonCommentType;
use App\Models\Admin\User;

class PersonComment extends Model
{
    protected $fillable = [
        'content',
        'user_id',
        'person_id',
        'person_comment_type_id',
        'active'
    ];
    
    public static $validator = [
        'person_id' => 'required|exists:people,id',
        'person_comment_type_id' => 'required|exists:person_comment_types,id',
        'content' => 'required|string|max:2000',
        'active' => 'boolean'
    ];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function PersonCommentType()
    {
        return $this->belongsTo(PersonCommentType::class);
    }
}
