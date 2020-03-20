<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Libraries\ModelTreatment;
use App\Resources\CRUD;

class CRUDcontroller extends Controller
{
    public function __construct()
    {
        $this->middleware('role:read', ['only' => ['index', 'show']]);
        $this->middleware('role:insert', ['only' => ['store', 'multipleAdd']]);
        $this->middleware('role:update', ['only' => ['update', 'multipleUpdate',]]);
        $this->middleware('role:delete', ['only' => ['destroy', 'nultipleDelete']]);

        $prefix = request()->route('prefix');

        $CRUDresources = CRUD::$resources;
        foreach ($CRUDresources as $module) {
            if($module['prefix'] == $prefix){
                if (array_key_exists('permission', $module)){
                    $this->middleware('permission:' . $module['permission']);
                }
            }
        }
    }
    private function isMethodAllowed($method, $prefix, $path)
    {        
        $CRUDresources = CRUD::$resources;

        $isAllowed = false;

        foreach ($CRUDresources as $module) {

            if($module['prefix'] == $prefix){

                $this->module = $module;

                $resources = $module['resources'];
                foreach ($resources as $resource) {
                    if($resource['path'] == $path && array_key_exists('model', $resource)){

                        $this->resource = $resource;

                        $fullCrud = array_key_exists('fullCrud', $resource) ? $resource['fullCrud'] : true;
                        $crudInclude = array_key_exists('crudInclude', $resource) ? explode(".",$resource['crudInclude']) : [];
                        $crudExclude = array_key_exists('crudExclude', $resource) ? explode(".",$resource['crudExclude']) : [];
                        $allowedMethods = $fullCrud ? array_diff(['i','st','sh','u','d','mu','md', 'ma'], $crudExclude) : $crudInclude;
                        if (in_array($method, $allowedMethods)) {
                            $this->pk = array_key_exists('pk', $resource) ? $resource['pk'] : 'id';
                            $this->model = $resource['model'];
                            $isAllowed = true;
                        }
                        break;
                    }
                }
                break;
            }
        }
        return $isAllowed;
    }

    public function index($prefix, $path)
    {
        if($this->isMethodAllowed('i', $prefix, $path)){
            $model = $this->model;
            return $model::all();
        }
        else {
            return [];
        }
    }
    public function store(Request $request,$prefix, $path)
    {
        return $this->isMethodAllowed('st', $prefix, $path) ? $this->rStore($this->model, $request, $this->pk) : [];
    }
    public function show($prefix, $path, $id)
    {
        if($this->isMethodAllowed('sh', $prefix, $path)){
            $model = $this->model;
            return $model::where($this->pk, $id)->first();
        }
        else {
            return [];
        }
    }
    public function update(Request $request, $prefix, $path, $id)
    {
        if($this->isMethodAllowed('u', $prefix, $path)){
            $model = $this->model;
            $obj = $model::where($this->pk, $id)->first();
            return $this->rUpdate($this->model, $obj, $request->all(), $this->pk);
        }
        else {
            return [];
        }
    }
    public function destroy($prefix, $path, $id)
    {
        if($this->isMethodAllowed('d', $prefix, $path)){
            $model = $this->model;
            $obj = $model::where($this->pk, $id)->first();
            return $this->rDestroy($obj);
        }
        else {
            return [];
        }
    }
    public function multipleUpdate(Request $request, $prefix, $path)
    {
        return $this->isMethodAllowed('mu', $prefix, $path) ? $this->rMultipleUpdate($this->model, $request, $this->pk) : [];
    }
    public function multipleDelete(Request $request, $prefix, $path)
    {
        return $this->isMethodAllowed('md', $prefix, $path) ? $this->rMultipleDelete($this->model, $request, $this->pk) : [];
    }
    public function multipleAdd(Request $request, $prefix, $path)
    {
        return $this->isMethodAllowed('ma', $prefix, $path) ? $this->rMultipleAdd($this->model, $request) : [];
    }
}
