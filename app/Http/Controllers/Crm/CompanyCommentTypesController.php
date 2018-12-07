<?php

namespace App\Http\Controllers\Crm;

use App\Models\Crm\CompanyCommentType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class CompanyCommentTypesController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:read', ['only' => ['index', 'show']]);
        $this->middleware('role:insert', ['only' => ['store']]);
        $this->middleware('role:update', ['only' => ['update', 'multipleUpdate']]);
        $this->middleware('role:delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        return CompanyCommentType::orderBy('name', 'asc')->get();
    }
    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:200',
        ]);
        if ($validator->fails()) {
            return ['status' => -1, 'msg' => $validator->errors()];
        }
        $result = CompanyCommentType::create($request->all());
        return ['status' => 0, 'id' => $result->id];
    }
    public function show(CompanyCommentType $companyCommentType)
    {
        return $companyCommentType;
    }
    public function edit(CompanyCommentType $companyCommentType)
    {
        //
    }
    public function update(Request $request, CompanyCommentType $companyCommentType)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|max:200',
            'active' => 'boolean'
        ]);
        if ($validator->fails()) {
            return ['status' => -1, 'msg' => $validator->errors()];
        }
        $companyCommentType->update($request->all());
        return ['status' => 0, 'id' => $companyCommentType->id];
    }
    public function destroy(CompanyCommentType $companyCommentType)
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

        CompanyCommentType
            ::whereIn('id', $ids)
            ->update($request->get('request'));

        return ['status' => 0];
    }
}
