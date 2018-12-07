<?php

namespace App\Http\Controllers\Crm;

use App\Models\Crm\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class TasksController extends Controller
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
        return Task::orderBy('name', 'asc')->get();
    }
    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:200',
        ]);
        if ($validator->fails()) {
            return ['status' => -1, 'msg' => $validator->errors()];
        }
        $result = Task::create($request->all());
        return ['status' => 0, 'id' => $result->id];
    }
    public function show(Task $task)
    {
        return $task;
    }
    public function edit(Task $task)
    {
        //
    }
    public function update(Request $request, Task $task)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|max:200',
            'active' => 'boolean'
        ]);
        if ($validator->fails()) {
            return ['status' => -1, 'msg' => $validator->errors()];
        }
        $task->update($request->all());
        return ['status' => 0, 'id' => $task->id];
    }
    public function destroy(Task $task)
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

        Task
            ::whereIn('id', $ids)
            ->update($request->get('request'));

        return ['status' => 0];
    }
}
