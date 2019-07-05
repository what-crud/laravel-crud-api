<?php

namespace App\Models\Store;

use Illuminate\Database\Eloquent\Model;
use App\Models\Store\TransactionProduct;
use App\Models\Store\Section;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'quantity',
        'image',
        'thumbnail',
        'section_id',
        'active'
    ];
    
    public static $validator = [
        'name' => 'required|string|max:500',
        'slug' => 'nullable|string|max:500',
        'description' => 'required|string|max:2000',
        'price' => 'required|numeric',
        'quantity' => 'required|integer',
        'image' => 'nullable|string',
        'thumbnail' => 'required|string',
        'section_id' => 'required|exists:sections,id',
        'active' => 'boolean'
    ];

    public function productTransactions()
    {
        return $this->hasMany(TransactionProduct::class, 'product_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }
}
