<?php
declare(strict_types=1);

use App\Sharp\Forms\ArticleForm;
use App\Sharp\Forms\CategoryForm;
use App\Sharp\Forms\DocumentForm;
use App\Sharp\Forms\RoleForm;
use App\Sharp\Forms\SectionForm;
use App\Sharp\Forms\SubscriptionForm;
use App\Sharp\Forms\SuperCategoryForm;
use App\Sharp\Lists\ArticlesList;
use App\Sharp\Lists\CategoriesList;
use App\Sharp\Lists\DocumentsList;
use App\Sharp\Lists\PermissionsList;
use App\Sharp\Lists\RolesList;
use App\Sharp\Lists\SectionsList;
use App\Sharp\Lists\SubscriptionsList;
use App\Sharp\Lists\SuperCategoriesList;
use App\Sharp\UserForm;
use App\Sharp\UsersList;
use App\Sharp\Auth\MySharpCheckHandler;

return [

    // Required. The name of your app, as it will be displayed in Sharp.
    "name" => "Patrul",

    // Optional. You can here customize the URL segment in which Sharp will live. Default in "sharp".
    "custom_url_segment" => "admin",

    // Optional. You can prevent Sharp version to be displayed in the page title. Default is true.
    "display_sharp_version_in_title" => true,

    "display_breadcrumb" => true,

    // Optional. Handle extensions.
//    "extensions" => [
//        "assets" => [
//            "strategy" => "asset",
//            "head" => [
//                "/css/inject.css",
//            ],
//        ],
//
//        "activate_custom_fields" => false,
//    ],

    // Required. Your entities list; each one must define a "list",
    // and can define 'form', "validator", "policy" and "authorizations".
    "entities" => [
        'users' => [
            'list' => UsersList::class,
            'form' => UserForm::class,
            'label' => 'Users'
        ],
        'articles' => [
            'list' => ArticlesList::class,
            'form' => ArticleForm::class,
            'label' => 'Articles'
        ],
        'categories' => [
            'list' => CategoriesList::class,
            'form' => CategoryForm::class,
            'label' => 'Categories'
        ],
        'super_categories' => [
            'list' => SuperCategoriesList::class,
            'form' => SuperCategoryForm::class,
            'label' => 'Super Categories'
        ],
        'documents' => [
            'list' => DocumentsList::class,
            'form' => DocumentForm::class,
            'label' => 'Documents'
        ],
        'sections' => [
            'list' => SectionsList::class,
            'form' => SectionForm::class,
            'label' => 'Sections'
        ],
        'roles' => [
            'list' => RolesList::class,
            'form' => RoleForm::class,
            'label' => 'Roles'
        ],
        'permissions' => [
            'list' => PermissionsList::class,
            'form' => RoleForm::class,
            'label' => 'Permissions'
        ],
        'subscriptions' => [
            'list' => SubscriptionsList::class,
            'form' => SubscriptionForm::class,
            'label' => 'Subscriptions'
        ],


//        "my_entity" => [
//            "list" => \App\Sharp\MyEntitySharpList::class,
//            'form' => \App\Sharp\MyEntitySharpForm::class,
//            "validator" => \App\Sharp\MyEntitySharpValidator::class,
//            "policy" => \App\Sharp\Policies\MyEntityPolicy::class,
//        ],
    ],

    // Optional. Your dashboards list; each one must define a "view", and can define "policy".
    "dashboards" => [
//        "my_dashboard" => [
//            "view" => \App\Sharp\MyDashboardView::class,
//            "policy" => \App\Sharp\Policies\MyDashboardPolicy::class,
//        ],
    ],

    // Optional. Your global filters list, which will be displayed in the main menu.
    "global_filters" => [
//        "my_global_filter" => \App\Sharp\Filters\MyGlobalFilter::class
    ],

    // Required. The main menu (left bar), which may contain links to entities, dashboards
    // or external URLs, grouped in categories.
    "menu" => [
        [
            "label" => "Користувачі",
            "icon" => "fa-page",
            "entity" => "users"
        ],
        [
            "label" => "Ролі",
            "icon" => "fa-page",
            "entity" => "roles"
        ],
        [
            "label" => "Права",
            "icon" => "fa-page",
            "entity" => "permissions"
        ],
        [
            "label" => "Підписки",
            "icon" => "fa-page",
            "entity" => "subscriptions"
        ],
        [
            "label" => "Контент",
            "entities" => [
                [
                    "label" => "My Dashboard",
                    "icon" => "fa-dashboard",
                    "dashboard" => "my_dashboard"
                ],
                [
                    "label" => "My Entity",
                    "icon" => "fa-page",
                    "entity" => "my_entity"
                ],
            ]
        ],
        [
            "label" => "Статті",
            "icon" => "fa-page",
            "entity" => "articles"
        ],
        [
            "label" => "Документи",
            "icon" => "fa-page",
            "entity" => "documents"
        ],
        [
            "label" => "Розділи",
            "icon" => "fa-page",
            "entity" => "sections"
        ],
        [
            "label" => "Категорії",
            "icon" => "fa-page",
            "entity" => "categories"
        ],
        [
            "label" => "Супер Категорії",
            "icon" => "fa-page",
            "entity" => "super_categories"
        ],
    ],

    // Optional. Your file upload configuration.
    "uploads" => [
        // Tmp directory used for file upload.
        "tmp_dir" => env("SHARP_UPLOADS_TMP_DIR", "tmp"),

        // These two configs are used for thumbnail generation inside Sharp.
        "thumbnails_disk" => env("SHARP_UPLOADS_THUMBS_DISK", "public"),
        "thumbnails_dir" => env("SHARP_UPLOADS_THUMBS_DIR", "thumbnails"),
    ],

    // Optional. Auth related configuration.
    "auth" => [
        // Name of the login and password attributes of the User Model.
        "login_attribute" => "email",
        "password_attribute" => "password",

        // Name of the attribute used to display the current user in the UI.
        "display_attribute" => "name",

        // Optional additional auth check.
       "check_handler" => App\Sharp\Auth\MySharpCheckHandler::class,

        // Optional custom guard
        //"guard" => "sharp",
    ],

    "login_page_message_blade_path" => env("SHARP_LOGIN_PAGE_MESSAGE_BLADE_PATH", "sharp/_login-page-message"),

];
