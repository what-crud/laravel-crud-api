<?php

namespace App\Models\Store;

use Illuminate\Database\Eloquent\Model;
use App\Models\Store\Transaction;

class Customer extends Model
{
    protected $fillable = [
        'firstname',
        'lastname',
        'company',
        'registration_number',
        'phone',
        'email',
        'street',
        'zip_code',
        'city',
        'comments'
    ];
    
    public static $validator = [
        'firstname' => 'required|string|max:500',
        'lastname' => 'required|string|max:500',
        'company' => 'nullable|boolean',
        'registration_number' => 'nullable|string',
        'phone' => 'nullable|string|max:20',
        'email' => 'required|string|max:200',
        'street' => 'nullable|string|max:200',
        'zip_code' => 'nullable|string|max:10',
        'city' => 'nullable|string|max:100',
        'comments' => 'nullable|string|max:2000'
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'customer_id');
    }
}
