<?php

Route::apiResource('/crud/tasks', 'Crud\TasksController');
Route::post('/crud/tasks/multiple-update', ['uses' => 'Crud\TasksController@multipleUpdate']);
Route::post('/crud/tasks/multiple-delete', ['uses' => 'Crud\TasksController@multipleDelete']);
Route::post('/crud/tasks/multiple-add', ['uses' => 'Crud\TasksController@multipleAdd']);

// File management
Route::group(['prefix' => 'files'], function () {
    // file upload
    Route::post('/file-upload', 'Files\FileController@fileUpload');
});
