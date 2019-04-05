<?php

namespace App\Models\Crm;

use Illuminate\Database\Eloquent\Model;
use App\Models\Crm\CompanyType;
use App\Models\Crm\StreetPrefix;
use App\Models\Crm\Position;
use App\Models\Crm\CompanyComment;
use App\Models\Crm\CompanyFile;

class Company extends Model
{
    
    protected $fillable = [
        'name',
        'common_name',
        'company_type_id',
        'nip',
        'regon',
        'krs',
        'street_prefix_id',
        'street',
        'house_number',
        'apartment_number',
        'zip_code',
        'city',
        'borough',
        'county',
        'voivodship',
        'email',
        'web_page',
        'fax',
        'coordinates_lat',
        'coordinates_lng',
        'coordinates_checked',
        'google_map_place',
        'parent_company_id',
        'correspondence_street',
        'correspondence_house_number',
        'correspondence_apartment_number',
        'correspondence_zip_code',
        'correspondence_city',
        'correspondence_borough',
        'correspondence_county',
        'correspondence_voivodship',
        'correspondence_street_prefix_id',
        'active',
    ];
    
    public static $validator = [
        'name' => 'required|string',
        'common_name' => 'required|string|max:1000',
        'company_type_id' => 'required|exists:company_types,id',
        'active' => 'boolean'
    ];

    protected $appends = ['address'];
    
    public function getAddressAttribute()
    {
        $street = $this->street;
        $house = $this->house_number;
        $apartment = $this->apartment_number;
        return preg_replace('/\s+/', ' ',$street." ".$house.($apartment != null ? " lok. ".$apartment : ""));
    }

    public function positions()
    {
        return $this->hasMany(Position::class);
    }

    public function companyType()
    {
        return $this->belongsTo(CompanyType::class);
    }
    public function streetPrefix()
    {
        return $this->belongsTo(StreetPrefix::class, 'street_prefix_id');
    }
    public function correspondenceStreetPrefix()
    {
        return $this->belongsTo(StreetPrefix::class, 'correspondence_street_prefix_id');
    }
    public function comments()
    {
        return $this->hasMany(CompanyComment::class)->orderBy('id', 'desc');
    }
    public function files()
    {
        return $this->hasMany(CompanyFile::class)->orderBy('id', 'desc');
    }
}
