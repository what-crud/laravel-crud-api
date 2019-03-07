<?php

namespace App\Http\Controllers\Crm;

use App\Models\Crm\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompaniesController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:read', ['only' => ['index', 'show']]);
        $this->middleware('role:insert', ['only' => ['store']]);
        $this->middleware('role:update', ['only' => ['update', 'multipleUpdate']]);
        $this->middleware('role:delete', ['only' => ['destroy']]);
    }

    private $m = Company::class;
    private $pk = 'id';

    public function index()
    {
        return Company
            ::with('companyType')
            ->with('streetPrefix')
            ->orderBy('common_name', 'asc')
            ->get();
    }
    public function store(Request $request)
    {
        return $this->rStore($this->m, $request, $this->pk);
    }
    public function show(Company $model)
    {
        $id = $model->id;
        $companyInfo = Company
            ::where('id', $id)
            ->with('companyType')
            ->with('streetPrefix')
            ->with('files')
            ->with('positions', 'positions.person')
            ->with('positions.positionCompanys.Company')
            ->with(
                'comments.companyCommentType',
                'comments.user'
            )
            ->with(
                ['comments' => function ($query) {
                    $query->orderBy('created_at', 'desc');
                }],
                'comments.companyCommentType',
                'comments.user'
            )
            ->first();
        return $companyInfo;
    }
    public function update(Request $request, Company $model)
    {
        return $this->rUpdate($this->m, $model, $request->all(), $this->pk);
    }
    public function destroy(Company $model)
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
