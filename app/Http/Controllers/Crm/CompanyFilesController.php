<?php

namespace App\Http\Controllers\Crm;

use App\Models\Crm\CompanyFile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompanyFilesController extends Controller
{
    public function index()
    {
        return CompanyFile
            ::orderBy('id', 'asc')
            ->with('company')
            ->get();
    }
    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        echo $request->get('files');
        //$filePath = $request->get('files.file')->store('company-files');
        // $validator = Validator::make($request->all(), [
        //     'company_id' => 'required|exists:companies,id',
        //     'original_filename' => 'required|string',
        //     'description' => 'required|string|max:500',
        // ]);
        // if ($validator->fails()) {
        //     return ['status' => -1, 'msg' => $validator->errors()];
        // }
        // $companyFile = [
        //     'company_id' => $request->get('company_id'),
        //     'filename' => $filePath,
        //     'original_filename' => $request->get('company_comment_type_id'),
        //     'description' => $request->get('description'),
        // ];
        // $result = CompanyFile::create($companyFile);
        // return ['status' => 0, 'id' => $result->id];
    }
    public function show(CompanyFile $companyFile)
    {
        return $companyFile;
    }
    public function edit(CompanyFile $companyFile)
    {
        //
    }
    public function update(Request $request, CompanyFile $companyFile)
    {
        //
    }
    public function destroy(CompanyFile $companyFile)
    {
        //
    }
}
