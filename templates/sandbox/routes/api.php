<?php

// Authentication and modifying authenticated user
Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function () {

    //Route::post('/register', ['uses' => 'AuthController@register','as' => 'auth.register']);
    Route::post('/login', ['uses' => 'AuthController@login', 'as' => 'auth.login']);
    Route::post('/logout', ['uses' => 'AuthController@logout', 'as' => 'auth.logout']);

    //  Middleware - authentication
    Route::group(['middleware' => ['auth.jwt']], function () {
        Route::get('/user', ['uses' => 'AuthController@getUser', 'as' => 'auth.getUser']);
        Route::post('/user', ['uses' => 'AuthController@editUser', 'as' => 'auth.editUser'])->middleware('role:update');
        Route::post('/user-password', ['uses' => 'AuthController@editUserPassword', 'as' => 'auth.editUserPassword'])->middleware('role:update');
        Route::post('/refresh-token', ['uses' => 'AuthController@refreshToken', 'as' => 'auth.refreshToken']);
    });

});

Route::apiResource('/demo/tasks', 'Demo\TasksController');
Route::post('/demo/tasks/multiple-update', ['uses' => 'Demo\TasksController@multipleUpdate']);
Route::post('/demo/tasks/multiple-delete', ['uses' => 'Demo\TasksController@multipleDelete']);
Route::post('/demo/tasks/multiple-add', ['uses' => 'Demo\TasksController@multipleAdd']);