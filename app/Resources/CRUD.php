<?php
namespace App\Resources;

class CRUD
{
    public static $resources = [
        [
            'prefix' => 'crm',
            'permission' => 'CRM',
            'namespace' => 'Crm',
            'resources' => [
                ['path' => 'companies', 'controller' => 'CompaniesController', 'model' => 'App\Models\Crm\Company'],
                ['path' => 'people', 'controller' => 'PeopleController', 'model' => 'App\Models\Crm\Person', 'custom' => [
                    ['path' => '-list/{mode}/{search?}', 'method' => 'get', 'function' => 'itemsList'],
                    ['path' => '/search', 'method' => 'post', 'function' => 'search']]
                ],
                ['path' => 'positions', 'controller' => 'PositionsController', 'model' => 'App\Models\Crm\Position', 'custom' => [
                    ['path' => '/{id}/tasks', 'method' => 'get', 'function' => 'positionTasks']]
                ],
                ['path' => 'company-comments', 'controller' => 'CompanyCommentsController', 'model' => 'App\Models\Crm\CompanyComment'],
                ['path' => 'person-comments', 'controller' => 'PersonCommentsController', 'model' => 'App\Models\Crm\PersonComment'],
                ['path' => 'position-tasks', 'controller' => 'PositionTasksController', 'model' => 'App\Models\Crm\PositionTask', 'delete' => true, 'multipleAdd' => true],
                ['path' => 'company-types', 'controller' => 'CompanyTypesController', 'model' => 'App\Models\Crm\CompanyType'],
                ['path' => 'company-comment-types', 'controller' => 'CompanyCommentTypesController', 'model' => 'App\Models\Crm\CompanyCommentType'],
                ['path' => 'person-comment-types', 'controller' => 'PersonCommentTypesController', 'model' => 'App\Models\Crm\PersonCommentType'],
                ['path' => 'tasks', 'controller' => 'TasksController', 'model' => 'App\Models\Crm\Task'],
                ['path' => 'street-prefixes', 'controller' => 'StreetPrefixesController', 'model' => 'App\Models\Crm\StreetPrefix'],
                ['path' => 'sexes', 'controller' => 'SexesController', 'model' => 'App\Models\Crm\Sex'],
                ['path' => 'languages', 'controller' => 'LanguagesController', 'model' => 'App\Models\Crm\Language'],
                ['path' => 'company-files', 'controller' => 'CompanyFilesController', 'model' => 'App\Models\Crm\CompanyFile'],
            ],
        ],
        [
            'prefix' => 'admin',
            'permission' => 'ADMIN',
            'namespace' => 'Admin',
            'resources' => [
                ['path' => 'users', 'controller' => 'UsersController', 'model' => 'App\Models\Admin\User', 'custom' => [
                    ['path' => '/{id}/reset-password', 'method' => 'put', 'function' => 'resetPassword'],
                    ['path' => '/{id}/permissions', 'method' => 'get', 'function' => 'userPermissions']]
                ],
                ['path' => 'permissions', 'controller' => 'PermissionsController', 'model' => 'App\Models\Admin\Permission', 'custom' => [
                    ['path' => '/{id}/users', 'method' => 'get', 'function' => 'permissionUsers']]
                ],
                ['path' => 'user-permissions', 'controller' => 'UserPermissionsController', 'model' => 'App\Models\Admin\UserPermission', 'delete' => true, 'multipleAdd' => true],
                ['path' => 'user-types', 'controller' => 'UserTypesController', 'model' => 'App\Models\Admin\UserType', 'custom' => [
                    ['path' => '/{id}/reset-password', 'method' => 'put', 'function' => 'resetPassword'],
                    ['path' => '/{id}/permissions', 'method' => 'get', 'function' => 'userPermissions']]
                ],
            ],
        ],
    ];
}