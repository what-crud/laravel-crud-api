<?php

namespace App\Http\Controllers\Crm;

use App\Models\Crm\Person;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Support\Facades\DB;
use App\Libraries\ModelTreatment;

class PeopleController extends Controller
{
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
    public function asyncData(Request $request)
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
    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'distinction' => 'string|nullable',
            'sex_id' => 'required|exists:sexes,id',
            'language_id' => 'required|exists:languages,id',
            'email' => 'string|nullable',
            'phone' => 'string|nullable',
        ]);
        if ($validator->fails()) {
            return ['status' => -1, 'msg' => $validator->errors()];
        }
        $result = Person::create($request->all());
        return ['status' => 0, 'id' => $result->id];
    }
    public function show(Person $person)
    {
        $id = $person->id;
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
    public function edit(Person $person)
    {
        //
    }
    public function update(Request $request, Person $person)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'string',
            'lastname' => 'string',
            'distinction' => 'string|nullable',
            'sex_id' => 'exists:sexes,id',
            'language_id' => 'exists:languages,id',
            'email' => 'string|nullable',
            'phone' => 'string|nullable',
            'active' => 'boolean'
        ]);
        if ($validator->fails()) {
            return ['status' => -1, 'msg' => $validator->errors()];
        }
        $person->update($request->all());
        return ['status' => 0, 'id' => $person->id];
    }
    public function destroy(Person $person)
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

        Person
            ::whereIn('id', $ids)
            ->update($request->get('request'));

        return ['status' => 0];
    }
}
