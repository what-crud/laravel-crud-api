<?php

namespace App\Http\Controllers\Crm;

use App\Models\Crm\Person;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Libraries\ModelTreatment;

class PeopleController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:read', ['only' => ['index', 'show', 'search']]);
        $this->middleware('role:insert', ['only' => ['store']]);
        $this->middleware('role:update', ['only' => ['update', 'multipleUpdate']]);
        $this->middleware('role:delete', ['only' => ['destroy']]);
    }

    private $m = Person::class;
    private $pk = 'id';

    public function index()
    {
        return Person
            ::orderBy('lastname', 'asc')
            ->orderBy('firstname', 'asc')
            ->orderBy('distinction', 'asc')
            ->with('language')
            ->with('sex')
            ->get();
    }
    public function store(Request $request)
    {
        return $this->rStore($this->m, $request, $this->pk);
    }
    public function show(Person $model)
    {
        $id = $model->id;
        $personInfo = Person
            ::where('id', $id)
            ->with('language')
            ->with('sex')
            ->with('positions', 'positions.company')
            ->with('comments', 'comments.personCommentType', 'comments.user')
            ->with(
                ['comments' => function ($query) {
                    $query->where('active', true);
                }],
                'comments.personCommentType',
                'comments.user'
            )
            ->first();
        return $personInfo;
    }
    public function update(Request $request, Person $model)
    {
        return $this->rUpdate($this->m, $model, $request->all(), $this->pk);
    }
    public function destroy(Person $model)
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
    public function search(Request $request)
    {
        $columns = ['id', 'firstname', 'lastname', 'email', 'phone', 'sex', 'language'];

        $model = Person
        ::with('language')
        ->with('sex')
        ->leftJoin(
            DB::raw("
            (SELECT
                id as sexes_id,
                name as sex
            FROM
                sexes) s
            "),
            's.sexes_id', '=', 'people.sex_id'
        )
        ->leftJoin(
            DB::raw("
            (SELECT
                id as languages_id,
                name as language
            FROM
                languages) l
            "),
            'l.languages_id', '=', 'people.language_id'
        );

        return ModelTreatment::getAsyncData($model, $request, $columns, 'crm', 'people', 'lastname', 'ASC');
    }
}
