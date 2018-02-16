<?php

namespace App\Http\Controllers\Crm;

use App\Models\Crm\PositionTask;
use App\Models\Crm\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class PositionTasksController extends Controller
{
    public function index()
    {
        return PositionTask::orderBy('id', 'asc')
            ->with(
                'position',
                'task',
                'position.company',
                'position.person'
            )
            ->get();
    }
    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'position_id' => 'required|exists:positions,id',
            'task_id' => 'required|exists:tasks,id',
        ]);
        if ($validator->fails()) {
            return ['status' => -1, 'msg' => $validator->errors()];
        }
        $result = PositionTask::create($request->all());
        return ['status' => 0, 'id' => $result->id];
    }
    public function show(PositionTask $positionTask)
    {
        return $positionTask;
    }
    public function edit(PositionTask $positionTask)
    {
        //
    }
    public function update(Request $request, PositionTask $positionTask)
    {
        $validator = Validator::make($request->all(), [
            'position_id' => 'exists:positions,id',
            'task_id' => 'exists:tasks,id',
            'active' => 'boolean'
        ]);
        if ($validator->fails()) {
            return ['status' => -1, 'msg' => $validator->errors()];
        }
        $positionTask->update($request->all());
        return ['status' => 0, 'id' => $positionTask->id];
    }
    public function destroy(PositionTask $positionTask)
    {
        $positionTask->delete();
    }
    public function multipleDelete(Request $request)
    {
        $ids = $request->get('ids');

        PositionTask
            ::whereIn('id', $ids)
            ->delete();

        return ['status' => 0];
    }
}
