<?php

namespace App\Http\Controllers\Crm;

use App\Models\Crm\CompanyComment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Validator;

class CompanyCommentsController extends Controller
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
        return CompanyComment
            ::orderBy('id', 'desc')
            ->with('company')
            ->with('user')
            ->with('companyCommentType')
            ->get();
    }
    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        $userId = Auth::user()->id;
        $validator = Validator::make($request->all(), [
            'company_id' => 'required|exists:companies,id',
            'company_comment_type_id' => 'required|exists:company_comment_types,id',
            'content' => 'required|string|max:2000',
        ]);
        if ($validator->fails()) {
            return ['status' => -1, 'msg' => $validator->errors()];
        }
        $companyComment = [
            'company_id' => $request->get('company_id'),
            'company_comment_type_id' => $request->get('company_comment_type_id'),
            'content' => $request->get('content'),
            'user_id' => $userId
        ];
        $result = CompanyComment::create($companyComment);
        return ['status' => 0, 'id' => $result->id];
    }
    public function show(CompanyComment $companyComment)
    {
        return $companyComment;
    }
    public function edit(CompanyComment $companyComment)
    {
        //
    }
    public function update(Request $request, CompanyComment $companyComment)
    {
        $userId = Auth::user()->id;
        $validator = Validator::make($request->all(), [
            'company_id' => 'exists:companies,id',
            'company_comment_type_id' => 'exists:company_comment_types,id',
            'content' => 'string|max:2000',
            'active' => 'boolean'
        ]);
        if ($validator->fails()) {
            return ['status' => -1, 'msg' => $validator->errors()];
        }
        $companyComment->update($request->all());
        $companyComment->update([
            'user_id' => $userId
        ]);
        return ['status' => 0, 'id' => $companyComment->id];
    }
    public function destroy(CompanyComment $companyComment)
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

        CompanyComment
            ::whereIn('id', $ids)
            ->update($request->get('request'));

        return ['status' => 0];
    }
}
