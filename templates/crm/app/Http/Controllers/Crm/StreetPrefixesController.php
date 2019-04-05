<?php

namespace App\Http\Controllers\Crm;

use App\Models\Crm\StreetPrefix;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StreetPrefixesController extends Controller
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
        return StreetPrefix::orderBy('id', 'asc')->get();
    }
    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        //
    }
    public function show(StreetPrefix $streetPrefix)
    {
        //
    }
    public function edit(StreetPrefix $streetPrefix)
    {
        //
    }
    public function update(Request $request, StreetPrefix $streetPrefix)
    {
        //
    }
    public function destroy(StreetPrefix $streetPrefix)
    {
        //
    }
}
