<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Store\Product;
use App\Helpers\Functions;

class ProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:read', ['only' => ['index']]);
        $this->middleware('role:insert', ['only' => ['store']]);
    }

    private $m = Product::class;
    private $pk = 'id';

    public function index()
    {
        return Product
            ::with('section')
            ->orderBy('name', 'asc')
            ->get();
    }
    public function store(Request $request)
    {
        $initSlug = $request->get('name');
        if ($request->has('slug')) {
            $initSlug = $request->get('slug');
        }
        $computed = [
            'slug' => Functions::slugify($initSlug),
        ];
        return $this->rStore($this->m, $request, $this->pk, $computed);
    }
    public function update(Request $request, $id)
    {
        $model = Product::find($id);
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
