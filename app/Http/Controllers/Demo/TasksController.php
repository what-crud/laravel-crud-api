<?php

namespace App\Http\Controllers\Demo;

use App\Models\Crm\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TasksController extends Controller
{

    private $m = Task::class;
    private $pk = 'id';

    public function index()
    {
        return Task::all();
    }
    public function store(Request $request)
    {
        return $this->rStore($this->m, $request, $this->pk, $computed);
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
}
