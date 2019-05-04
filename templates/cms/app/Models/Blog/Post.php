<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;
use App\Models\Blog\PostTag;
use App\Models\Blog\Category;
use App\Models\Admin\User;

class Post extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'content',
        'image',
        'thumbnail',
        'active',
        'user_id',
        'category_id'
    ];
    
    public static $validator = [
        'title' => 'required|string|max:500',
        'slug' => 'nullable|string|max:500',
        'description' => 'required|string|max:2000',
        'content' => 'required|string',
        'image' => 'nullable|string',
        'thumbnail' => 'required|string',
        'active' => 'boolean',
        'user_id' => 'nullable|exists:users,id',
        'category_id' => 'required|exists:categories,id'
    ];

    public function postTags()
    {
        return $this->hasMany(PostTag::class, 'post_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
