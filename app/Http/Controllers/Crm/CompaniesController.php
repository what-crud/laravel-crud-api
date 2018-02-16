<?php

namespace App\Http\Controllers\Crm;

use App\Models\Crm\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class CompaniesController extends Controller
{
    public function index()
    {
        return Company
            ::orderBy('id', 'asc')
            ->with('companyType')
            ->with('streetPrefix')
            ->get();
    }
    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'common_name' => 'required|string|max:1000',
            'company_type_id' => 'required|exists:company_types,id',
        ]);
        if ($validator->fails()) {
            return ['status' => -1, 'msg' => $validator->errors()];
        }
        $result = Company::create($request->all());
        return ['status' => 0, 'id' => $result->id];
    }
    public function show(Company $company)
    {
        $id = $company->id;
        $companyInfo = Company
            ::where('id', $id)
            ->with('companyType')
            ->with('streetPrefix')
            ->with('positions', 'positions.person')
            ->with('comments', 'comments.companyCommentType', 'comments.user')
            ->with(
                ['comments' => function ($query) {
                    $query->where('active', true);
                }],
                'comments.companyCommentType',
                'comments.user'
            )
            ->first();
        return $companyInfo;
    }
    public function edit(Company $company)
    {
        //
    }
    public function update(Request $request, Company $company)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|max:1000',
            'common_name' => 'string|max:1000',
            'company_type_id' => 'exists:company_types,id',
            'active' => 'boolean'
        ]);
        if ($validator->fails()) {
            return ['status' => -1, 'msg' => $validator->errors()];
        }
        $company->update($request->all());
        return ['status' => 0, 'id' => $company->id];
    }
    public function destroy(Company $company)
    {
        //
    }
    public function multipleUpdate(Request $request)
    {
        $ids = $request->get('ids');

        $validator = Validator::make($request->get('request'), [
            'active' => 'boolean'
        ]);
        if ($validator->fails()) {
            return ['status' => -1, 'msg' => $validator->errors()];
        }

        Company
            ::whereIn('id', $ids)
            ->update($request->get('request'));

        return ['status' => 0];
    }
}
