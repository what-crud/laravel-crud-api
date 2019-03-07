<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\User;
use App\Models\Admin\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:read', ['only' => ['index', 'show']]);
        $this->middleware('role:insert', ['only' => ['store']]);
        $this->middleware('role:update', ['only' => ['update', 'multipleUpdate']]);
        $this->middleware('role:delete', ['only' => ['destroy']]);
    }

    private $m = User::class;
    private $pk = 'id';

    public function index()
    {
        return User::with('userType')->orderBy('id', 'asc')->get();
    }
    public function store(Request $request)
    {
        $password = str_random(8);

        $computed = [
            'password' => bcrypt($password)
        ];
        return $this->rStore($this->m, $request, $this->pk, $computed);
    }
    public function show(User $model)
    {
        return $model;
    }
    public function update(Request $request, User $model)
    {
        return $this->rUpdate($this->m, $model, $request->all(), $this->pk);
    }
    public function destroy(User $model)
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
    public function resetPassword(Request $request, $id)
    {
        $user = User::find($id);
        $password = str_random(8);

        $data = [
            'initial_password' => $password,
            'password' => bcrypt($password)
        ];
        $user->update($data);
        return ['status' => 0, 'id' => $user->id];
    }
    public function userPermissions(Request $request, $id)
    {
        $userPermissions = Permission
            ::orderBy('id', 'asc')
            ->with(
                [
                    'permissionUsers' => function($query) use($id) {
                        $query->where('user_id', $id);
                    },
                ]
            )
            ->get();
        return $userPermissions;
    }
}
