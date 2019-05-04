<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;
use App\Models\Blog\PostTag;

class Tag extends Model
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

    public function tagPosts()
    {
        return $this->hasMany(PostTag::class, 'tag_id');
    }
}
