<?php

use App\Resources\CRUD;

// Authentication and modifying authenticated user
Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function () {

    //Route::post('/register', ['uses' => 'AuthController@register','as' => 'auth.register']);
    Route::post('/login', ['uses' => 'AuthController@login', 'as' => 'auth.login']);
    Route::post('/logout', ['uses' => 'AuthController@logout', 'as' => 'auth.logout']);

    //  Middleware - authentication
    Route::group(['middleware' => ['auth.jwt']], function () {
        Route::get('/user', ['uses' => 'AuthController@getUser', 'as' => 'auth.getUser']);
        Route::get('/user-permissions', ['uses' => 'AuthController@getUserPermissions', 'as' => 'auth.getUserPermissions']);
        Route::post('/user', ['uses' => 'AuthController@editUser', 'as' => 'auth.editUser'])->middleware('role:update');
        Route::post('/user-password', ['uses' => 'AuthController@editUserPassword', 'as' => 'auth.editUserPassword'])->middleware('role:update');
        Route::post('/refresh-token', ['uses' => 'AuthController@refreshToken', 'as' => 'auth.refreshToken']);
    });

});

// Custom CRUD operations

//  Middleware - authentication
Route::group(['middleware' => ['auth.jwt']], function ($CRUD) {
    
    // CRUD operations
    Route::get('/crud/{prefix}/{path}', ['uses' => 'CRUDcontroller@index']);
    Route::get('/crud/{prefix}/{path}/{id}', ['uses' => 'CRUDcontroller@show']);
    Route::put('/crud/{prefix}/{path}/{id}', ['uses' => 'CRUDcontroller@update']);
    Route::delete('/crud/{prefix}/{path}/{id}', ['uses' => 'CRUDcontroller@destroy']);
    Route::post('/crud/{prefix}/{path}', ['uses' => 'CRUDcontroller@store']);
    Route::post('/crud/{prefix}/{path}/multiple-update', ['uses' => 'CRUDcontroller@multipleUpdate']);
    Route::post('/crud/{prefix}/{path}/multiple-delete', ['uses' => 'CRUDcontroller@multipleDelete']);
    Route::post('/crud/{prefix}/{path}/multiple-add', ['uses' => 'CRUDcontroller@multipleAdd']);

    // File management
    Route::group(['prefix' => 'files'], function () {
        // file upload
        Route::post('/file-upload', 'Files\FileController@fileUpload');
    });

    $CRUDresources = CRUD::$resources;

    foreach ($CRUDresources as $module) {

        $routeGroup = [];
        if(array_key_exists('prefix', $module)){
            $routeGroup['prefix'] = $module['prefix'];
        }
        if(array_key_exists('permission', $module)){
            $routeGroup['middleware'] = ['permission:' . $module['permission']];
        }
        if(array_key_exists('namespace', $module)){
            $routeGroup['namespace'] = $module['namespace'];
        }

        $resources = $module['resources'];

        // module route group
        Route::group($routeGroup, function () use ($resources) {
            foreach ($resources as $resource) {
                if(array_key_exists('controller', $resource)){
                    // resource rest api routes
                    Route::apiResource('/' . $resource['path'], $resource['controller']);
                    // resource multiple update
                    Route::post('/' . $resource['path'] . '/multiple-update', $resource['controller'] . '@multipleUpdate');
                    // resource multiple delete
                    $delete = array_key_exists('delete', $resource) ? $resource['delete'] : false;
                    if ($delete) {
                        Route::post('/' . $resource['path'] . '/multiple-delete', $resource['controller'] . '@multipleDelete');
                    }
                    // resource multiple add
                    $multipleAdd = array_key_exists('multipleAdd', $resource) ? $resource['multipleAdd'] : false;
                    if ($multipleAdd) {
                        Route::post('/' . $resource['path'] . '/multiple-add', $resource['controller'] . '@multipleAdd');
                    }
                    // resource search, sort and paginate
                    $search = array_key_exists('search', $resource) ? $resource['search'] : false;
                    if ($search) {
                        Route::post('/' . $resource['path'] . '/search', $resource['controller'] . '@search');
                    }
                    // resource custom routes
                    if (array_key_exists('custom', $resource)) {
                        $custom = $resource['custom'];
                        foreach ($custom as $customResource) {
                            $path = '/' . $resource['path'] . $customResource['path'];
                            $function = $resource['controller'] . '@' . $customResource['function'];
                            switch ($customResource['method']) {
                                case 'get':
                                    Route::get($path, $function);
                                    break;
                                case 'post':
                                    Route::post($path, $function);
                                    break;
                                case 'put':
                                    Route::put($path, $function);
                                    break;
                                case 'patch':
                                    Route::patch($path, $function);
                                    break;
                                case 'delete':
                                    Route::delete($path, $function);
                                    break;
                                default:
                                    break;
                            }
                        }
                    }
                }
            }
        });
    }
});