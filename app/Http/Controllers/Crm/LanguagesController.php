<?php

namespace App\Http\Controllers\Crm;

use App\Models\Crm\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LanguagesController extends Controller
{
    public function index()
    {
        return Language::orderBy('name', 'asc')->get();
    }
    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        $result = Language::create($request->all());
        return ['status' => 0, 'id' => $result->id];
    }
    public function show(Language $language)
    {
        //
    }
    public function edit(Language $language)
    {
        //
    }
    public function update(Request $request, Language $language)
    {
        $language->update($request->all());
        return ['status' => 0, 'id' => $language->id];
    }
    public function destroy(Language $language)
    {
        $language->delete();
        return ['status' => 0];
    }
}
