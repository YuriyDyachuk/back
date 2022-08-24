<?php
declare(strict_types=1);

use App\Http\Controllers\AdminApi\ArticleController as AdminArticleController;
use App\Http\Controllers\AdminApi\CategoryController as AdminCategoryController;
use App\Http\Controllers\AdminApi\DocumentController as AdminDocumentController;
use App\Http\Controllers\AdminApi\DocumentScraperController as AdminDocumentScraperController;
use App\Http\Controllers\AdminApi\SectionController as AdminSectionController;
use App\Http\Controllers\AdminApi\SuperCategoryController as AdminSuperCategoryController;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\DocumentController;
use App\Http\Controllers\Api\EntitiesSyncController;
use App\Http\Controllers\Api\SectionController;
use App\Http\Controllers\Api\SuperCategoryController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\SocialController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login/{provider}',  [UserController::class, 'socialAuth']);
Route::post('login',  [UserController::class, 'login'])->name('auth.login');
Route::post('register', [UserController::class, 'register'])
    ->name('register');
Route::group(['middleware' => ['web']], function () {
    Route::get('login/{provider}', [SocialController::class, 'redirect']);
    Route::get('login/{provider}/callback', [SocialController::class, 'callback']);
});
Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', [UserController::class, 'logout'])
        ->name('logout');

    Route::post('details', [UserController::class, 'details']);
});
    Route::post('reset-password/send-code', [UserController::class, 'resetPasswordRequest'])
        ->name('reset-password-send-code');
    Route::post('reset-password', [UserController::class, 'resetPassword'])
        ->name('reset-password');
Route::middleware('auth:api')->group(function () {
    Route::as('auth.')->group(function () {
//        Route::post('logout', [UserController::class, 'logout'])
//            ->name('logout');
    });

    Route::get('entities/sync/{lastSync}/status', [EntitiesSyncController::class, 'status'])
        ->where('lastSync', '[0-9]+')
        ->name('entities.sync.status');

    Route::group(['prefix' => 'super-categories/', 'as' => 'super-categories.'], function () {
        Route::get('sync/{lastSync}', [SuperCategoryController::class, 'sync'])
            ->where('lastSync', '[0-9]+')
            ->name('sync');
    });
    Route::apiResource('super-categories', SuperCategoryController::class)->only([
        'index', 'show',
    ]);

    Route::group(['prefix' => 'categories/', 'as' => 'categories.'], function () {
        Route::get('sync/{lastSync}', [CategoryController::class, 'sync'])
            ->where('lastSync', '[0-9]+')
            ->name('sync');
    });
    Route::apiResource('categories', CategoryController::class)->only([
        'index', 'show',
    ]);

    Route::group(['prefix' => 'documents/', 'as' => 'documents.'], function () {
        Route::get('sync/{lastSync}', [DocumentController::class, 'sync'])
            ->where('lastSync', '[0-9]+')
            ->name('sync');
    });
    Route::apiResource('documents', DocumentController::class)->only([
        'index', 'show',
    ]);

    Route::group(['prefix' => 'sections/', 'as' => 'sections.'], function () {
        Route::get('sync/{lastSync}', [SectionController::class, 'sync'])
            ->where('lastSync', '[0-9]+')
            ->name('sync');
    });
    Route::apiResource('sections', SectionController::class)->only([
        'index', 'show',
    ]);

    Route::group(['prefix' => 'articles/', 'as' => 'articles.'], function () {
        Route::get('sync/{lastSync}', [ArticleController::class, 'sync'])
            ->where('lastSync', '[0-9]+')
            ->name('sync');
    });
    Route::apiResource('articles', ArticleController::class)->only([
        'index', 'show',
    ]);

    Route::group(['prefix' => 'users/', 'as' => 'users.'], function () {
        Route::get('auth', [UserController::class, 'showIm'])
            ->name('show-auth');
        Route::get('info', [UserController::class, 'getUserInfo'])
            ->name('show-info');
        Route::post('link-social-account/{provider}', [UserController::class, 'linkSocialAccount'])
            ->name('link-social-account');
        Route::post('unlink-social-account/{provider}', [UserController::class, 'unlinkSocialAccount'])
            ->name('unlink-social-account');
        Route::post('update-info', [UserController::class, 'updateUserInfo'])
            ->name('update-info');
        Route::post('change-password', [UserController::class, 'changePassword'])
            ->name('change-password');
    });

    Route::group(['prefix' => 'admin/', 'as' => 'admin.'], function () {
        Route::apiResource('super-categories', AdminSuperCategoryController::class)->only([
            'store', 'update', 'destroy',
        ]);

        Route::apiResource('categories', AdminCategoryController::class)->only([
            'store', 'update', 'destroy',
        ]);

        Route::apiResource('documents', AdminDocumentController::class)->only([
            'store', 'update', 'destroy',
        ]);

        Route::apiResource('sections', AdminSectionController::class)->only([
            'store', 'update', 'destroy',
        ]);

        Route::apiResource('articles', AdminArticleController::class)->only([
            'store', 'update', 'destroy',
        ]);

        Route::get('document/scrap', [AdminDocumentScraperController::class, 'scrap'])->name('document.scrap');
    });
});
