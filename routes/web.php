<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\UserController;
use App\Mail\WelcomeEmail;
use App\Models\Admin;
use Illuminate\Support\Facades\Route;

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

Route::prefix('cms/')->middleware('guest:admin')->group(function () {
    Route::get('{guard}/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login']);

});

Route::prefix('cms/admin')->middleware('auth:admin,user')->group(function () {
    Route::view('/', 'cms.index')->name('demo');

    Route::resource('cities', CityController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('admins', AdminController::class);
    Route::resource('users', UserController::class);

    Route::get('edit-password', [AuthController::class, 'editPassword'])->name('edit-password');
    Route::put('update-password', [AuthController::class, 'UpdatePassword']);

    Route::get('edit-profile', [AuthController::class, 'editProfile'])->name('edit-profile');
    Route::put('update-profile', [AuthController::class, 'updateProfile']);

    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('test-email', function () {
    $admin = Admin::find(1);
    return new WelcomeEmail($admin);
});
