<?php

namespace App\Http\Controllers\Crm;

use App\Models\Crm\PersonComment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class PersonCommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:read', ['only' => ['index', 'show']]);
        $this->middleware('role:insert', ['only' => ['store']]);
        $this->middleware('role:update', ['only' => ['update', 'multipleUpdate']]);
        $this->middleware('role:delete', ['only' => ['destroy']]);
    }

    private $m = PersonComment::class;
    private $pk = 'id';

    public function index()
    {
        return PersonComment
            ::orderBy('id', 'desc')
            ->with('person')
            ->with('user')
            ->with('personCommentType')
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
    public function show(PersonComment $model)
    {
        return $model;
    }
    public function update(Request $request, PersonComment $model)
    {
        $userId = Auth::user()->id;
        $computed = [
            'user_id' => $userId
        ];
        return $this->rUpdate($this->m, $model, $request->all(), $this->pk, $computed);
    }
}
