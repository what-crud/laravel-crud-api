<?php

namespace App\Http\Controllers\Crm;

use App\Models\Crm\CompanyCommentType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompanyCommentTypesController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:read', ['only' => ['index', 'show']]);
        $this->middleware('role:insert', ['only' => ['store']]);
        $this->middleware('role:update', ['only' => ['update', 'multipleUpdate']]);
        $this->middleware('role:delete', ['only' => ['destroy']]);
    }

    private $m = CompanyCommentType::class;
    private $pk = 'id';

    public function index()
    {
        return CompanyCommentType::orderBy('name', 'asc')->get();
    }
    public function store(Request $request)
    {
        return $this->rStore($this->m, $request, $this->pk);
    }
    public function show(CompanyCommentType $model)
    {
        return $model;
    }
    public function update(Request $request, CompanyCommentType $model)
    {
        return $this->rUpdate($this->m, $model, $request->all(), $this->pk);
    }
    public function destroy(CompanyCommentType $model)
    {
        return $this->rDestroy($model);
    }
    public function multipleUpdate(Request $request)
    {
        return $this->rMultipleUpdate($this->m, $request, $this->pk);
    }
    public function multipleDelete(Request $request)
    {
        return $this->rMultipleDelete($this->m, $request, $this->pk);
    }
}
