<?php

namespace App\Http\Controllers\Blog;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Blog\Post;
use App\Models\Blog\Tag;
use Auth;
use App\Helpers\Functions;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:read', ['only' => ['index']]);
        $this->middleware('role:insert', ['only' => ['store']]);
    }

    private $m = Post::class;
    private $pk = 'id';

    public function index()
    {
        return Post
            ::with('postTags.tag')
            ->with('category')
            ->with('user')
            ->orderBy('id', 'desc')
            ->get();
    }
    public function store(Request $request)
    {
        $userId = Auth::user()->id;
        $initSlug = $request->get('title');
        if ($request->has('slug')) {
            $initSlug = $request->get('slug');
        }
        $computed = [
            'slug' => Functions::slugify($initSlug),
            'user_id' => $userId
        ];
        return $this->rStore($this->m, $request, $this->pk, $computed);
    }
    public function update(Request $request, $id)
    {
        $model = Post::find($id);
        $initSlug = $request->get('title');
        if ($request->has('slug')) {
            $initSlug = $request->get('slug');
        }
        $computed = [
            'slug' => Functions::slugify($initSlug)
        ];
        return $this->rUpdate($this->m, $model, $request->all(), $this->pk, $computed);
    }
    public function postTags(Request $request, $id)
    {
        $postTags = Tag
            ::orderBy('id', 'asc')
            ->with(
                [
                    'tagPosts' => function($query) use($id) {
                        $query->where('post_id', $id);
                    },
                ]
            )
            ->get();
        return $postTags;
    }
}
