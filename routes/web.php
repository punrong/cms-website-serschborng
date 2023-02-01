<?php

use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('home');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::group([
    'namespace' => 'App\Http\Controllers\Admin',
    'prefix' => 'admin',
    'middleware' => ['auth'],
], function () {
    // User
    Route::resource('user', 'UserController');
    Route::delete('user/delete/multiple', [UserController::class, 'deleteMultipleRecord'])->name('user.deleteMultipleRecord');
    Route::get('user/index/data', [UserController::class, 'getUserData'])->name('user.getData');

    // Role
    Route::resource('role', 'RoleController');
    Route::delete('role/delete/multiple', [RoleController::class, 'deleteMultipleRecord'])->name('role.deleteMultipleRecord');
    Route::get('role/index/data', [RoleController::class, 'getRoleData'])->name('role.getData');

    // Permission
    Route::resource('permission', 'PermissionController');
    Route::delete('permission/delete/multiple', [PermissionController::class, 'deleteMultipleRecord'])->name('permission.deleteMultipleRecord');
    Route::get('permission/index/data', [PermissionController::class, 'getPermissionData'])->name('permission.getData');

    Route::resource('post', 'PostController');
});