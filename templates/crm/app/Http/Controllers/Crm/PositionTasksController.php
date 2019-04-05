<?php

namespace App\Http\Controllers\Crm;

use App\Models\Crm\PositionTask;
use App\Models\Crm\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PositionTasksController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:read', ['only' => ['index', 'show']]);
        $this->middleware('role:insert', ['only' => ['store']]);
        $this->middleware('role:update', ['only' => ['update', 'multipleUpdate']]);
        $this->middleware('role:delete', ['only' => ['destroy']]);
    }

    private $m = PositionTask::class;
    private $pk = 'id';

    public function index()
    {
        return PositionTask
            ::join('positions', 'positions.id', '=', 'position_tasks.position_id')
            ->join('companies', 'positions.company_id', '=', 'companies.id')
            ->join('people', 'positions.person_id', '=', 'people.id')
            ->join('tasks', 'tasks.id', '=', 'position_tasks.task_id')
            ->orderBy('tasks.name', 'asc')
            ->orderBy('companies.common_name', 'asc')
            ->orderBy('people.lastname', 'asc')
            ->orderBy('people.firstname', 'asc')
            ->select('position_tasks.*')
            ->with(
                'position',
                'task',
                'position.company',
                'position.person'
            )
            ->get();
    }
    public function store(Request $request)
    {
        return $this->rStore($this->m, $request, $this->pk);
    }
    public function show(Task $model)
    {
        return $model;
    }
    public function update(Request $request, Task $model)
    {
        return $this->rUpdate($this->m, $model, $request->all(), $this->pk);
    }
    public function destroy(Task $model)
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
    public function multipleAdd(Request $request)
    {
        return $this->rMultipleAdd($this->m, $request);
    }
}
