<?php

namespace App\Http\Controllers\Crm;

use App\Models\Crm\Position;
use App\Models\Crm\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PositionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:read', ['only' => ['index', 'show']]);
        $this->middleware('role:insert', ['only' => ['store']]);
        $this->middleware('role:update', ['only' => ['update', 'multipleUpdate']]);
        $this->middleware('role:delete', ['only' => ['destroy']]);
    }

    private $m = Position::class;
    private $pk = 'id';

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
            ->with('positionTasks.task')
            ->get();
    }
    public function store(Request $request)
    {
        return $this->rStore($this->m, $request, $this->pk);
    }
    public function show($id)
    {
        return Position::where('id', $id)->first();
    }
    public function update(Request $request, Position $model)
    {
        return $this->rUpdate($this->m, $model, $request->all(), $this->pk);
    }
    public function destroy(Position $model)
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
}
