<?php

namespace App\Http\Controllers\Crm;

use App\Models\Crm\CompanyType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class CompanyTypesController extends Controller
{
    public function index()
    {
        return CompanyType::orderBy('name', 'asc')->get();
    }
    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:200',
            'code' => 'required|string|size:3'
        ]);
        if ($validator->fails()) {
            return ['status' => -1, 'msg' => $validator->errors()];
        }
        $result = CompanyType::create($request->all());
        return ['status' => 0, 'id' => $result->id];
    }
    public function show(CompanyType $companyType)
    {
        return $companyType;
    }
    public function edit(CompanyType $companyType)
    {
        //
    }
    public function update(Request $request, CompanyType $companyType)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|max:200',
            'code' => 'string|size:3',
            'active' => 'boolean'
        ]);
        if ($validator->fails()) {
            return ['status' => -1, 'msg' => $validator->errors()];
        }
        $companyType->update($request->all());
        return ['status' => 0, 'id' => $companyType->id];
    }
    public function destroy(CompanyType $companyType)
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

        CompanyType
            ::whereIn('id', $ids)
            ->update($request->get('request'));

        return ['status' => 0];
    }
}
