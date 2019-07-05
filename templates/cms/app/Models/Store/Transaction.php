<?php

namespace App\Models\Store;

use Illuminate\Database\Eloquent\Model;
use App\Models\Store\Customer;
use App\Models\Store\Status;
use App\Models\Store\TransactionProduct;

class Transaction extends Model
{
    protected $fillable = [
        'customer_id',
        'status_id',
        'accepted_at',
        'started_at',
        'sent_at',
        'delivered_at',
        'active'
    ];
    
    public static $validator = [
        'customer_id' => 'required|exists:categories,id',
        'status_id' => 'required|exists:categories,id',
        'accepted_at' => 'nullable|date',
        'started_at' => 'nullable|date',
        'sent_at' => 'nullable|date',
        'delivered_at' => 'nullable|date',
        'active' => 'boolean'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function transactionProducts()
    {
        return $this->hasMany(TransactionProduct::class, 'transaction_id');
    }
}
