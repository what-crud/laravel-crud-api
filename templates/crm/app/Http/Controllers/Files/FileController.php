<?php

namespace App\Http\Controllers\Files;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\Admin\UserPermission;
use App\Models\Admin\Permission;
use Validator;

class FileController extends Controller
{
    public function fileUpload(Request $request){

        //  check if the module exists
        $module = $request->get('module');
        $validator = Validator::make($request->all(), [
            'module' => 'required|exists:permissions,code',
        ]);
        if ($validator->fails()) {
            return ['status' => -2, 'msg' => $validator->errors()];
        }

        // check user permissions to the module
        $userId = Auth::user()->id;
        $permission = UserPermission
            ::whereHas('permission', function ($query) use ($module) {
                $query->where('code', $module);
            })
            ->where('user_id', $userId)
            ->first();

        // user has permission to uploading files in the module
        if ($permission !== null) {

            // extension checking
            $file = $request->file('file');
            $originalName = $file->getClientOriginalName();
            $whitelist = array('jpg', 'png', 'gif', 'jpeg', 'svg', 'txt', 'gif', 'doc', 'docx', 'xls', 'xlsx', 'mp3', 'mp4', 'avi', 'json', 'pdf');
            $explFilename = explode('.', $originalName);
            $fileExtension = strtolower(end($explFilename));
            if(!in_array($fileExtension, $whitelist))
            {
                return ['status' => -1, 'msg' => $fileExtension.' is invalid file extension. Allowed extensions: '.implode(', ', $whitelist)];
            }

            $table = $request->get('table');
            $field = $request->get('field');
            $uniqueFolder = time().substr("000000".$userId,-6);
            $relativePath = 'files/'.$module.'/'.$table.'/'.$field.'/'.$uniqueFolder;
            $file->storeAs('public/'.$relativePath, $originalName);
            return ['status' => 0, 'path' => $relativePath];
        }
        // user hasn't permissions
        else {
            return ['status' => -1, 'msg' => 'Error'];
        }
    }
}
