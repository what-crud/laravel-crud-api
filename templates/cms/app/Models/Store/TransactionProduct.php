<?php

namespace App\Models\Store;

use Illuminate\Database\Eloquent\Model;
use App\Models\Store\Product;
use App\Models\Store\Transaction;

class TransactionProduct extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'product_id',
        'transaction_id',
        'quantity', 
        'value'
    ];
    
    public static $validator = [
        'product_id' => 'required|exists:products,id',
        'transaction_id' => 'required|exists:transactions,id',
        'quantity' => 'integer',
        'value' => 'numeric'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }
}
