<?php

namespace App\Models\Crm;

use Illuminate\Database\Eloquent\Model;
use App\Models\Crm\Company;

class CompanyFile extends Model
{
    protected $fillable = [
        'company_id',
        'file',
        'file_2',
        'description',
        'active'
    ];
    
    public static $validator = [
        'company_id' => 'required|exists:companies,id',
        'file' => 'required|string',
        'file_2' => 'string|nullable',
        'description' => 'string|nullable',
        'active' => 'boolean',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
