<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\UserPermission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserPermissionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:read', ['only' => ['index', 'show']]);
        $this->middleware('role:insert', ['only' => ['store']]);
        $this->middleware('role:update', ['only' => ['update', 'multipleUpdate']]);
        $this->middleware('role:delete', ['only' => ['destroy']]);
    }

    private $m = UserPermission::class;
    private $pk = 'id';

    public function index()
    {
        return UserPermission::orderBy('id', 'asc')->with('user')->with('permission')->get();
    }
    public function store(Request $request)
    {
        return $this->rStore($this->m, $request, $this->pk);
    }
    public function show(UserPermission $model)
    {
        return $model;
    }
    public function update(Request $request, UserPermission $model)
    {
        return $this->rUpdate($this->m, $model, $request->all(), $this->pk);
    }
    public function destroy(UserPermission $model)
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
