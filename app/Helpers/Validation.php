<?php
namespace App\Helpers;

class Validation
{
    public static function noRequire($obj)
    {
        $objNoRequire = [];
        
        foreach ($obj as $a => $b) {
            $objNoRequire[$a] = implode('|', array_diff(explode('|' , $b), ['required']));
        }

        return $objNoRequire;
    }
    public static function update($obj, $id)
    {
        $rObj = [];
        
        foreach ($obj as $a => $b) {
            $rules = array_diff(explode('|' , $b), ['required']);
            foreach ($rules as &$rule) {
                $rule = strpos($rule, 'unique:') === false ? $rule : $rule . ',' . $id;
            }
            $rObj[$a] = implode('|', $rules);
        }

        return $rObj;
    }
}