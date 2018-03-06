<?php

namespace App\Http\Controllers\Crm;

use App\Models\Crm\Position;
use App\Models\Crm\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class PositionsController extends Controller
{
    public function index()
    {
        return Position
            ::join('companies', 'positions.company_id', '=', 'companies.id')
            ->join('people', 'positions.person_id', '=', 'people.id')
            ->orderBy('companies.common_name', 'asc')
            ->orderBy('people.lastname', 'asc')
            ->orderBy('people.firstname', 'asc')
            ->select('positions.*')
            ->with('company')
            ->with('person')
            ->get()->sortBy(function ($product, $key) {
                return $product['company']['name'];
            });
    }
    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'person_id' => 'required|exists:people,id',
            'company_id' => 'required|exists:companies,id',
            'name' => 'string|max:255|nullable',
            'phone' => 'string|max:50|nullable',
            'phone_2' => 'string|max:50|nullable',
            'phone_3' => 'string|max:50|nullable',
            'email' => 'string|max:255|nullable',
            'email_2' => 'string|max:255|nullable',
            'comment' => 'string|max:500|nullable',
        ]);
        if ($validator->fails()) {
            return ['status' => -1, 'msg' => $validator->errors()];
        }
        $result = Position::create($request->all());
        return ['status' => 0, 'id' => $result->id];
    }
    public function show(Position $position)
    {
        return $position;
    }
    public function edit(Position $position)
    {
    }
    public function update(Request $request, Position $position)
    {
        $validator = Validator::make($request->all(), [
            'person_id' => 'exists:people,id',
            'company_id' => 'exists:companies,id',
            'name' => 'string|max:255|nullable',
            'phone' => 'string|max:50|nullable',
            'phone_2' => 'string|max:50|nullable',
            'phone_3' => 'string|max:50|nullable',
            'email' => 'string|max:255|nullable',
            'email_2' => 'string|max:255|nullable',
            'comment' => 'string|max:500|nullable',
            'active' => 'boolean'
        ]);
        if ($validator->fails()) {
            return ['status' => -1, 'msg' => $validator->errors()];
        }
        $position->update($request->all());
        return ['status' => 0, 'id' => $position->id];
    }
    public function destroy(Position $position)
    {
        //
    }
    public function positionTasks(Request $request, $id)
    {
        $positionTasks = Task
            ::orderBy('id', 'asc')
            ->with(
                [
                    'taskPositions' => function($query) use($id) {
                        $query->where('position_id', $id);
                    },
                ]
            )
            ->get();
        return $positionTasks;
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

        Position
            ::whereIn('id', $ids)
            ->update($request->get('request'));

        return ['status' => 0];
    }
}
