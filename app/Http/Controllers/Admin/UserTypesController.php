<?php

namespace App\Http\Controllers\Admin;

use App\Models\Crm\UserType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserTypesController extends Controller
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
        return UserType::orderBy('id', 'asc')->get();
    }
    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        //
    }
    public function show(UserType $userType)
    {
        //
    }
    public function edit(UserType $userType)
    {
        //
    }
    public function update(Request $request, UserType $userType)
    {
        //
    }
    public function destroy(UserType $userType)
    {
        //
    }
}
