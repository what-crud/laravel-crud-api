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
        Route::post('/user', ['uses' => 'Auth\AuthController@editUser','as' => 'auth.editUser']);
        Route::post('/user-password', ['uses' => 'Auth\AuthController@editUserPassword','as' => 'auth.editUserPassword']);
        Route::post('/refresh-token', ['uses' => 'Auth\AuthController@refreshToken','as' => 'auth.refreshToken']);
    });

});

//  Middleware - authentication
Route::group(['middleware' => ['auth.jwt']], function () {

    //  Permission - CRM
    Route::group(['prefix' => 'crm', 'middleware' => ['permission:CRM']], function () {
        Route::apiResource('/companies', 'Crm\CompaniesController');
        Route::apiResource('/people', 'Crm\PeopleController');
        Route::apiResource('/positions', 'Crm\PositionsController');
        Route::apiResource('/company-comments', 'Crm\CompanyCommentsController');
        Route::apiResource('/person-comments', 'Crm\PersonCommentsController');
        Route::apiResource('/position-tasks', 'Crm\PositionTasksController');
        Route::apiResource('/company-types', 'Crm\CompanyTypesController');
        Route::apiResource('/company-comment-types', 'Crm\CompanyCommentTypesController');
        Route::apiResource('/person-comment-types', 'Crm\PersonCommentTypesController');
        Route::apiResource('/tasks', 'Crm\TasksController');
        Route::apiResource('/street-prefixes', 'Crm\StreetPrefixesController');
        Route::apiResource('/sexes', 'Crm\SexesController');
        Route::apiResource('/languages', 'Crm\LanguagesController');
        Route::apiResource('/company-files', 'Crm\CompanyFilesController');
        Route::apiResource('/person-files', 'Crm\PersonFilesController');
        // multiple update
        Route::post('/companies/multiple-update', 'Crm\CompaniesController@multipleUpdate');
        Route::post('/people/multiple-update', 'Crm\PeopleController@multipleUpdate');
        Route::post('/positions/multiple-update', 'Crm\PositionsController@multipleUpdate');
        Route::post('/company-comments/multiple-update', 'Crm\CompanyCommentsController@multipleUpdate');
        Route::post('/person-comments/multiple-update', 'Crm\PersonCommentsController@multipleUpdate');
        Route::post('/company-types/multiple-update', 'Crm\CompanyTypesController@multipleUpdate');
        Route::post('/company-comment-types/multiple-update', 'Crm\CompanyCommentTypesController@multipleUpdate');
        Route::post('/person-comment-types/multiple-update', 'Crm\PersonCommentTypesController@multipleUpdate');
        Route::post('/tasks/multiple-update', 'Crm\TasksController@multipleUpdate');
        //multiple delete
        Route::post('/position-tasks/multiple-delete', 'Crm\PositionTasksController@multipleDelete');
        //multiple add
        Route::post('/position-tasks/multiple-add', 'Crm\PositionTasksController@multipleAdd');
        // custom
        Route::get('/positions/{id}/tasks', ['uses' => 'Crm\PositionsController@positionTasks', 'as' => 'crmPositions.positionTasks']);
    });

    //  Permission - ADMIN
    Route::group(['prefix' => 'admin', 'middleware' => ['permission:ADMIN']], function () {
        Route::apiResource('/users', 'Admin\UsersController');
        Route::apiResource('/permissions', 'Admin\PermissionsController');
        Route::apiResource('/user-permissions', 'Admin\UserPermissionsController');
        // multiple update
        Route::post('/users/multiple-update', 'Admin\UsersController@multipleUpdate');
        Route::post('/permissions/multiple-update', 'Admin\PermissionsController@multipleUpdate');
        //multiple delete
        Route::post('/user-permissions/multiple-delete', 'Admin\UserPermissionsController@multipleDelete');
        //multiple add
        Route::post('/user-permissions/multiple-add', 'Admin\UserPermissionsController@multipleAdd');
        // custom
        Route::put('/users/{id}/reset-password', ['uses' => 'Admin\UsersController@resetPassword', 'as' => 'adminUsers.resetPassword']);
        Route::get('/users/{id}/permissions', ['uses' => 'Admin\UsersController@userPermissions', 'as' => 'adminUsers.userPermissions']);
    });

    // File management
    Route::group(['prefix' => 'files'], function () {
        // file upload
        Route::post('/file-upload', 'Files\FileController@fileUpload');
    });
});

