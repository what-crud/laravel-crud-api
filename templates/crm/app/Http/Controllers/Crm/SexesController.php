<?php

namespace App\Http\Controllers\Crm;

use App\Models\Crm\Sex;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SexesController extends Controller
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
        return Sex::orderBy('id', 'asc')->get();
    }
    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        //
    }
    public function show(Sex $sex)
    {
        //
    }
    public function edit(Sex $sex)
    {
        //
    }
    public function update(Request $request, Sex $sex)
    {
        //
    }
    public function destroy(Sex $sex)
    {
        //
    }
}
