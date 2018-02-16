<?php

namespace App\Models\Crm;

use Illuminate\Database\Eloquent\Model;
use App\Models\Crm\Company;

class CompanyFile extends Model
{
    protected $fillable = [
        'company_id',
        'filename',
        'original_filename',
        'mime',
        'uploaded',
        'description',
        'active'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
