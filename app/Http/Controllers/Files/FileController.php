<?php

namespace App\Http\Controllers\Files;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\Crm\UserPermission;
use App\Models\Crm\Permission;
use Validator;

class FileController extends Controller
{
    public function fileUpload(Request $request){
        $module = $request->get('module');
        $validator = Validator::make($request->all(), [
            'module' => 'required|exists:permissions,code',
        ]);
        if ($validator->fails()) {
            return ['status' => -1, 'msg' => $validator->errors()];
        }

        $userId = Auth::user()->id;
        $folder = $request->get('folder');
        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();
        $uniqueFolder = $userId.'-'.time();
        $permission = UserPermission
            ::whereHas('permission', function ($query) use ($module) {
                $query->where('code', $module);
            })
            ->where('user_id', $userId)
            ->first();
        if ($permission !== null) {
            $file->storeAs('public/files/'.$module.'/'.$folder.'/'.$uniqueFolder, $originalName);
            return 'files/'.$module.'/'.$folder.'/'.$uniqueFolder;
        }
        else {
            return ['status' => -1, 'msg' => ''];
        }
    }
}
