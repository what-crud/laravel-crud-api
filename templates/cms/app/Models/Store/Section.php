<?php

namespace App\Models\Store;

use Illuminate\Database\Eloquent\Model;
use App\Models\Store\Product;

class Section extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'name',
        'slug'
    ];
    
    public static $validator = [
        'name' => 'required|string',
        'slug' => 'nullable|string'
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'product_id');
    }
}
