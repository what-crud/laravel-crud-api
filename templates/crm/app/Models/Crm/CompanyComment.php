<?php

namespace App\Models\Crm;

use Illuminate\Database\Eloquent\Model;
use App\Models\Crm\Company;
use App\Models\Crm\CompanyCommentType;
use App\Models\Admin\User;

class CompanyComment extends Model
{
    protected $fillable = [
        'content',
        'user_id',
        'company_id',
        'company_comment_type_id',
        'active'
    ];
    
    public static $validator = [
        'company_id' => 'required|exists:companies,id',
        'company_comment_type_id' => 'required|exists:company_comment_types,id',
        'content' => 'required|string|max:2000',
        'active' => 'boolean'
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
