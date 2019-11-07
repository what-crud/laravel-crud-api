<?php
namespace App\Resources;

class CRUD
{
    public static $resources = [
        [
            'prefix' => 'cms',
            'permission' => 'CMS',
            'namespace' => 'Cms',
            'resources' => [
                ['path' => 'messages', 'controller' => 'MessagesController', 'model' => 'App\Models\Cms\Message'],
                ['path' => 'settings', 'controller' => 'SettingsController', 'model' => 'App\Models\Cms\Settings'],
                ['path' => 'menu-items', 'controller' => 'MenuItemsController', 'model' => 'App\Models\Cms\MenuItem'],
            ],
        ],
        [
            'prefix' => 'store',
            'permission' => 'STORE',
            'namespace' => 'Store',
            'resources' => [
                ['path' => 'sections', 'controller' => 'SectionsController', 'model' => 'App\Models\Store\Section'],
                ['path' => 'products', 'controller' => 'ProductsController', 'model' => 'App\Models\Store\Product'],
                ['path' => 'customers', 'controller' => 'CustomersController', 'model' => 'App\Models\Store\Customer'],
                ['path' => 'transactions', 'controller' => 'TransactionsController', 'model' => 'App\Models\Store\Transaction'],
                ['path' => 'statuses', 'controller' => 'StatusesController', 'model' => 'App\Models\Store\Status', 'fullCrud' => false, 'crudInclude' => 'i'],
                ['path' => 'transaction-products', 'controller' => 'TransactionProductsController', 'model' => 'App\Models\Store\TransactionProduct'],
            ],
        ],
        [
            'prefix' => 'blog',
            'permission' => 'BLOG',
            'namespace' => 'Blog',
            'resources' => [
                ['path' => 'tags', 'controller' => 'TagsController', 'model' => 'App\Models\Blog\Tag'],
                ['path' => 'post-tags', 'controller' => 'PostTagsController', 'model' => 'App\Models\Blog\PostTag'],
                ['path' => 'posts', 'controller' => 'PostsController', 'model' => 'App\Models\Blog\Post', 'custom' => [
                    ['path' => '/{id}/tags', 'method' => 'get', 'function' => 'postTags']]
                ],
                ['path' => 'categories', 'controller' => 'CategoriesController', 'model' => 'App\Models\Blog\Category'],
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
                ['path' => 'user-types', 'controller' => 'UserTypesController', 'model' => 'App\Models\Admin\UserType'],
            ],
        ],
    ];
}