<?php

namespace App\Libraries;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

trait ModelTreatment
{
    public static function getAsyncData($model, $request, $columns, $connection, $table, $defaultSortColumn, $defaultOrder){

        $rowsPerPage = $request->get('rowsPerPage');
        $sortBy = $request->get('sortBy');
        $sortDesc = $request->get('sortDesc');
        $search = $request->get('search');
        $searchPhrases = explode (" ", $search);
        $filterColumns = $request->get('filterColumns');
        $deleteMode = $request->get('deleteMode');
        $activeColumnName = $request->get('activeColumnName');
        if(in_array($deleteMode, ['soft', 'both'])) {
            $selectedStatuses = $request->get('selectedStatuses');
            $model->whereIn($activeColumnName, $selectedStatuses);
        }
        if($search != ''){
            foreach ($searchPhrases as $searchPhrase) {
                $model->where(function($query) use ($columns, $searchPhrase){
                    for ($i = 0; $i < count($columns); $i++) {
                        if($i == 0){
                            $query->where($columns[$i], 'like', '%'.$searchPhrase.'%');
                        }
                        else{
                            $query->orwhere($columns[$i], 'like', '%'.$searchPhrase.'%');
                        }
                    }
                });
            }
        }
        foreach ($filterColumns as $filterColumn) {
            if($filterColumn['value'] != null && in_array($filterColumn['name'], $columns)) {
                $val = $filterColumn['value'];
                $col = $filterColumn['name'];
                $mode = $filterColumn['mode'];
                $model->where(function($query) use ($col, $val, $mode){
                    switch ($mode) {
                      case 'like':
                        $query->where($col, 'like', '%'.$val.'%');
                        break;
                      case 'equals':
                        $query->where($col, '=', $val);
                        break;
                      case 'list':
                        $tmpList = explode(";", $val);
                        $query->whereIn($col, $tmpList);
                        break;
                      default:
                          break;
                    }
                });
            }
        }
        if($sortBy != null && $sortDesc != null){
            for ($i = 0; $i < count($sortBy); $i++) {
                $direction = $sortDesc[$i] == 'true' ? 'desc' : 'asc';
                $model->orderBy($sortBy[$i], $direction);
            }
        }
        else{
            $model->orderBy($defaultSortColumn, $defaultOrder);
        }
        return $model->paginate($rowsPerPage);
    }

}