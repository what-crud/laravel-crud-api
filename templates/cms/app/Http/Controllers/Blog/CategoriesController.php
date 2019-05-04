<?php

namespace App\Http\Controllers\Blog;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Blog\Category;
use App\Helpers\Functions;

class CategoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:insert', ['only' => ['store']]);
        $this->middleware('role:update', ['only' => ['update']]);
    }

    private $m = Category::class;
    private $pk = 'id';

    public function store(Request $request)
    {
        $initSlug = $request->get('name');
        if ($request->has('slug')) {
            $initSlug = $request->get('slug');
        }
        $computed = [
            'slug' => Functions::slugify($initSlug)
        ];
        return $this->rStore($this->m, $request, $this->pk, $computed);
    }
    public function update(Request $request, $id)
    {
        $model = Category::find($id);
        $initSlug = $request->get('name');
        if ($request->has('slug')) {
            $initSlug = $request->get('slug');
        }
        $computed = [
            'slug' => Functions::slugify($initSlug)
        ];
        return $this->rUpdate($this->m, $model, $request->all(), $this->pk, $computed);
    }
}
