<?php

namespace App\Http\Controllers\Blog;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Blog\PostTag;

class PostTagsController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:read', ['only' => ['index']]);
    }

    public function index()
    {
        return PostTag
            ::with('post.category')
            ->with('tag')
            ->get();
    }
}
