<?php

namespace App\Libraries;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

trait REST
{
    // store item
    public function rStore($model, $request, $primaryKey, $computed = [])
    {
        $fields = $model::$validator;
        $validator = Validator::make($request->all(), $fields);
        if ($validator->fails()) {
            return ['status' => -2, 'msg' => $validator->errors()];
        }
        $insert = $computed;
        foreach ($fields as $key => $value) {
            if($request->has($key)){
                $insert[$key] = $request->get($key);
            }
        }
        $result = $model::create($insert);
        return ['status' => 0, 'id' => $result[$primaryKey]];
    }
    // update item
    public function rUpdate($model, $obj, $newValues, $primaryKey, $customFillable = false, $fillable = [])
    {
        $fields = \ValidationHelper::update($model::$validator, $obj[$primaryKey]);
        $validator = Validator::make($newValues, $fields);
        if ($validator->fails()) {
            return ['status' => -2, 'msg' => $validator->errors()];
        }
        if($customFillable){
            $update = [];
            foreach($newValues as $key => $value){
                if(in_array($key, $fillable)){
                    $update[$key] = $value;
                }
            }
        }
        else{
            $update = $newValues;
        }

        $obj->update($update);
        return ['status' => 0, 'id' => $obj[$primaryKey]];
    }
    // destroy item
    public function rDestroy($obj)
    {
        $obj->delete();
        return ['status' => 0];
    }
    // update multiple items
    public function rMultipleUpdate($model, $request, $primaryKey, $customFillable = false, $fillable = [])
    {
        $ids = $request->get('ids');

        $fields = \ValidationHelper::noRequire($model::$validator);
        $validator = Validator::make($request->all(), $fields);
        if ($validator->fails()) {
            return ['status' => -2, 'msg' => $validator->errors()];
        }

        $newValues = $request->get('request');
        if($customFillable){
            $update = [];
            foreach($newValues as $key => $value){
                if(in_array($key, $fillable)){
                    $update[$key] = $value;
                }
            }
        }
        else{
            $update = $newValues;
        }
        
        $model
            ::whereIn($primaryKey, $ids)
            ->update($update);

        return ['status' => 0];
    }
    // delete multiple items
    public function rMultipleDelete($model, $request, $primaryKey)
    {
        $ids = $request->get('ids');

        $model::whereIn($primaryKey, $ids)->delete();

        return ['status' => 0];
    }
    // add multiple items
    public function rMultipleAdd($model, $request)
    {
        $items = $request->get('items');

        $model::insert($items);
    }
}