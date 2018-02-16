<?php

namespace App\Models\Crm;

use Illuminate\Database\Eloquent\Model;
use App\Models\Crm\Company;
use App\Models\Crm\CompanyCommentType;
use App\Models\User;

class CompanyComment extends Model
{
    protected $fillable = [
        'content',
        'user_id',
        'company_id',
        'company_comment_type_id',
        'active'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function companyCommentType()
    {
        return $this->belongsTo(CompanyCommentType::class);
    }
}
