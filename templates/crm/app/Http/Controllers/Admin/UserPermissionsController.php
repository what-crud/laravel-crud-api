<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\UserPermission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserPermissionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:read', ['only' => ['index']]);
    }

    public function index()
    {
        return UserPermission::orderBy('id', 'asc')->with('user')->with('permission')->get();
    }
}
