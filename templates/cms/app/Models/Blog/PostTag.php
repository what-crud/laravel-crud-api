<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;
use App\Models\Blog\Post;
use App\Models\Blog\Tag;

class PostTag extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'post_id',
        'tag_id'
    ];
    
    public static $validator = [
        'post_id' => 'required|exists:posts,id',
        'tag_id' => 'required|exists:tags,id'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class, 'tag_id');
    }
}
