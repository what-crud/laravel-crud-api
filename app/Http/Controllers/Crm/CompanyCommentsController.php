<?php

namespace App\Http\Controllers\Crm;

use App\Models\Crm\CompanyComment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class CompanyCommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:read', ['only' => ['index', 'show']]);
        $this->middleware('role:insert', ['only' => ['store']]);
        $this->middleware('role:update', ['only' => ['update', 'multipleUpdate']]);
        $this->middleware('role:delete', ['only' => ['destroy']]);
    }

    private $m = CompanyComment::class;
    private $pk = 'id';

    public function index()
    {
        return CompanyComment
            ::orderBy('id', 'desc')
            ->with('company')
            ->with('user')
            ->with('companyCommentType')
            ->get();
    }
    public function store(Request $request)
    {
        $userId = Auth::user()->id;
        $computed = [
            'user_id' => $userId
        ];
        return $this->rStore($this->m, $request, $this->pk, $computed);
    }
    public function show(CompanyComment $model)
    {
        return $model;
    }
    public function update(Request $request, CompanyComment $model)
    {
        $userId = Auth::user()->id;
        $computed = [
            'user_id' => $userId
        ];
        return $this->rUpdate($this->m, $model, $request->all(), $this->pk, $computed);
    }
    public function destroy(CompanyComment $model)
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
