<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;
use App\Models\Blog\Post;

class Category extends Model
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

    public function posts()
    {
        return $this->hasMany(Post::class, 'category_id');
    }
}
