<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $table = 'menu_items';
    public $timestamps = false;

    protected $fillable = [
        'text',
        'path',
        'parent_menu_item_id',
        'order',
        'active'
    ];
    
    public static $validator = [
        'text' => 'required|string',
        'path' => 'required|string',
        'parent_menu_item_id' => 'nullable|exists:menu_items,id',
        'order' => 'nullable|numeric',
        'active' => 'boolean',
    ];
}
