<?php

namespace App\Http\Controllers\Admin;

use App\Models\Crm\UserPermission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class UserPermissionsController extends Controller
{
    public function index()
    {
        return UserPermission::orderBy('id', 'asc')->with('user')->with('permission')->get();
    }
    public function create()
    {

    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'permission_id' => 'required|exists:permissions,id',
        ]);
        if ($validator->fails()) {
            return ['status' => -1, 'msg' => $validator->errors()];
        }
        $result = UserPermission::create($request->all());
        return ['status' => 0, 'id' => $result->id];
    }
    public function show(UserPermission $userPermission)
    {
        return $userPermission;
    }
    public function edit(UserPermission $userPermission)
    {
        //
    }
    public function update(Request $request, UserPermission $userPermission)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'exists:users,id',
            'permission_id' => 'exists:permissions,id',
            'active' => 'boolean'
        ]);
        if ($validator->fails()) {
            return ['status' => -1, 'msg' => $validator->errors()];
        }
        $userPermission->update($request->all());
        return ['status' => 0, 'id' => $userPermission->id];
    }
    public function destroy(UserPermission $userPermission)
    {
        $userPermission->delete();
    }
    public function multipleDelete(Request $request)
    {
        $ids = $request->get('ids');

        UserPermission
            ::whereIn('id', $ids)
            ->delete();

        return ['status' => 0];
    }
    public function multipleAdd(Request $request)
    {
        $items = $request->get('items');

        UserPermission::insert($items);
    }
}
