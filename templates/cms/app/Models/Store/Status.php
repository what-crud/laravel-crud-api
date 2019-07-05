<?php

namespace App\Models\Store;

use Illuminate\Database\Eloquent\Model;
use App\Models\Store\Transaction;

class Status extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'name',
        'code'
    ];
    
    public static $validator = [
        'name' => 'required|string',
        'code' => 'nullable|string'
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'status_id');
    }
}
