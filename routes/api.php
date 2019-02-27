<?php


// Authentication and modifying authenticated user
Route::group(['prefix' => 'auth'], function () {

    //Route::post('/register', ['uses' => 'AuthController@register','as' => 'auth.register']);
    Route::post('/login', ['uses' => 'Auth\AuthController@login','as' => 'auth.login']);
    Route::get('/logout', ['uses' => 'Auth\AuthController@logout','as' => 'auth.logout']);

    //  Middleware - authentication
    Route::group(['middleware' => ['auth.jwt']], function () {
        Route::get('/user', ['uses' => 'Auth\AuthController@getUser','as' => 'auth.getUser']);
        Route::get('/user-permissions', ['uses' => 'Auth\AuthController@getUserPermissions','as' => 'auth.getUserPermissions']);
        Route::post('/user', ['uses' => 'Auth\AuthController@editUser','as' => 'auth.editUser'])->middleware('role:update');
        Route::post('/user-password', ['uses' => 'Auth\AuthController@editUserPassword','as' => 'auth.editUserPassword'])->middleware('role:update');
        Route::post('/refresh-token', ['uses' => 'Auth\AuthController@refreshToken','as' => 'auth.refreshToken']);
    });

});

// Authentication and modifying authenticated user
Route::group(['prefix' => 'demo', 'namespace' => 'Demo'], function () {
    Route::apiResource('/tasks', 'TasksController');
    Route::post('/tasks/multiple-update', 'TasksController@multipleUpdate');
    Route::post('/tasks/multiple-delete', 'TasksController@multipleDelete');
});

//  Middleware - authentication
Route::group(['middleware' => ['auth.jwt']], function () {

    // File management
    Route::group(['prefix' => 'files'], function () {
        // file upload
        Route::post('/file-upload', 'Files\FileController@fileUpload');
    });

    //  Permission - CRM
    Route::group(['prefix' => 'crm', 'middleware' => ['permission:CRM'], 'namespace' => 'Crm'], function () {
        Route::apiResource('/companies', 'CompaniesController');
        Route::apiResource('/people', 'PeopleController');
        Route::apiResource('/positions', 'PositionsController');
        Route::apiResource('/company-comments', 'CompanyCommentsController');
        Route::apiResource('/person-comments', 'PersonCommentsController');
        Route::apiResource('/position-tasks', 'PositionTasksController');
        Route::apiResource('/company-types', 'CompanyTypesController');
        Route::apiResource('/company-comment-types', 'CompanyCommentTypesController');
        Route::apiResource('/person-comment-types', 'PersonCommentTypesController');
        Route::apiResource('/tasks', 'TasksController');
        Route::apiResource('/street-prefixes', 'StreetPrefixesController');
        Route::apiResource('/sexes', 'SexesController');
        Route::apiResource('/languages', 'LanguagesController');
        Route::apiResource('/company-files', 'CompanyFilesController');
        Route::apiResource('/person-files', 'PersonFilesController');
        // multiple update
        Route::post('/companies/multiple-update', 'CompaniesController@multipleUpdate');
        Route::post('/people/multiple-update', 'PeopleController@multipleUpdate');
        Route::post('/positions/multiple-update', 'PositionsController@multipleUpdate');
        Route::post('/company-comments/multiple-update', 'CompanyCommentsController@multipleUpdate');
        Route::post('/person-comments/multiple-update', 'PersonCommentsController@multipleUpdate');
        Route::post('/company-types/multiple-update', 'CompanyTypesController@multipleUpdate');
        Route::post('/company-comment-types/multiple-update', 'CompanyCommentTypesController@multipleUpdate');
        Route::post('/person-comment-types/multiple-update', 'PersonCommentTypesController@multipleUpdate');
        Route::post('/tasks/multiple-update', 'TasksController@multipleUpdate');
        //multiple delete
        Route::post('/position-tasks/multiple-delete', 'PositionTasksController@multipleDelete');
        //multiple add
        Route::post('/position-tasks/multiple-add', 'PositionTasksController@multipleAdd');
        // custom
        Route::get('/positions/{id}/tasks', ['uses' => 'PositionsController@positionTasks', 'as' => 'crmPositions.positionTasks']);
        //search
        Route::post('/people/search', 'PeopleController@search');
    });

    //  Permission - ADMIN
    Route::group(['prefix' => 'admin', 'middleware' => ['permission:ADMIN'], 'namespace' => 'Admin'], function () {
        Route::apiResource('/users', 'UsersController');
        Route::apiResource('/permissions', 'PermissionsController');
        Route::apiResource('/user-permissions', 'UserPermissionsController');
        Route::apiResource('/user-types', 'UserTypesController');
        // multiple update
        Route::post('/users/multiple-update', 'UsersController@multipleUpdate');
        Route::post('/permissions/multiple-update', 'PermissionsController@multipleUpdate');
        //multiple delete
        Route::post('/user-permissions/multiple-delete', 'UserPermissionsController@multipleDelete');
        //multiple add
        Route::post('/user-permissions/multiple-add', 'UserPermissionsController@multipleAdd');
        // custom
        Route::put('/users/{id}/reset-password', ['uses' => 'UsersController@resetPassword', 'as' => 'adminUsers.resetPassword']);
        Route::get('/users/{id}/permissions', ['uses' => 'UsersController@userPermissions', 'as' => 'adminUsers.userPermissions']);
    });
});

