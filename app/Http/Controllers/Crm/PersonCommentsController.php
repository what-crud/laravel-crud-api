<?php

namespace App\Http\Controllers\Crm;

use App\Models\Crm\PersonComment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Validator;

class PersonCommentsController extends Controller
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
        return PersonComment
            ::orderBy('id', 'desc')
            ->with('person')
            ->with('user')
            ->with('personCommentType')
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
            'person_id' => 'required|exists:people,id',
            'person_comment_type_id' => 'required|exists:person_comment_types,id',
            'content' => 'required|string|max:2000',
        ]);
        if ($validator->fails()) {
            return ['status' => -1, 'msg' => $validator->errors()];
        }
        $personComment = [
            'person_id' => $request->get('person_id'),
            'person_comment_type_id' => $request->get('person_comment_type_id'),
            'content' => $request->get('content'),
            'user_id' => $userId
        ];
        $result = PersonComment::create($personComment);
        return ['status' => 0, 'id' => $result->id];
    }
    public function show(PersonComment $personComment)
    {
        return $personComment;
    }
    public function edit(PersonComment $personComment)
    {
        //
    }
    public function update(Request $request, PersonComment $personComment)
    {
        $userId = Auth::user()->id;
        $validator = Validator::make($request->all(), [
            'person_id' => 'exists:people,id',
            'person_comment_type_id' => 'exists:person_comment_types,id',
            'content' => 'string|max:2000',
            'active' => 'boolean'
        ]);
        if ($validator->fails()) {
            return ['status' => -1, 'msg' => $validator->errors()];
        }
        $personComment->update($request->all());
        $personComment->update([
            'user_id' => $userId
        ]);
        return ['status' => 0, 'id' => $personComment->id];
    }
    public function destroy(PersonComment $personComment)
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

        PersonComment
            ::whereIn('id', $ids)
            ->update($request->get('request'));

        return ['status' => 0];
    }
}
