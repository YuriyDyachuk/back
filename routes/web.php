<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('https://patrul.app/');
});
//Route::get('/admin', function () {
//    return redirect('https://patrul.app/');
//});
Route::get('user/verify', [UserController::class, 'userVerifyByEmailLink']);
