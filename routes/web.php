<?php

use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\CategoryController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

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
    'prefix' => 'admin',
    'middleware' => ['auth'],
], function () {

    Route::group(['prefix' => 'api'], function(){
        Route::get('get/menusidebar/permissions', [AuthenticatedSessionController::class, 'getMenuSideBarPermission'])->name('menusidebar.getPermissions');
    });
    // User
    Route::resource('user', UserController::class);
    Route::group(['prefix' => 'user/api'], function (){
        Route::delete('delete/multiple', [UserController::class, 'deleteMultipleRecord'])->name('user.deleteMultipleRecord');
        Route::get('get/user/data', [UserController::class, 'getUserData'])->name('user.getData');
    });

    // Role
    Route::resource('role', RoleController::class);
    Route::group(['prefix' => 'role/api'], function (){
        Route::delete('delete/multiple', [RoleController::class, 'deleteMultipleRecord'])->name('role.deleteMultipleRecord');
        Route::get('get/role/data', [RoleController::class, 'getRoleData'])->name('role.getData');
        Route::get('get/rolelist', [RoleController::class, 'getRoleList'])->name('role.getRoleList');
    });

    // Permission
    Route::resource('permission', PermissionController::class);
    Route::group(['prefix' => 'permission/api'], function (){
        Route::delete('delete/multiple', [PermissionController::class, 'deleteMultipleRecord'])->name('permission.deleteMultipleRecord');
        Route::get('get/permission/data', [PermissionController::class, 'getPermissionData'])->name('permission.getData');
        Route::get('get/permissionlist', [PermissionController::class, 'getPermissionList'])->name('permission.getPermissionList');
    });

    // Post
    Route::resource('post', PostController::class);
    Route::group(['prefix' => 'post/api'], function (){
        Route::delete('delete/multiple', [PostController::class, 'deleteMultipleRecord'])->name('post.deleteMultipleRecord');
        Route::get('get/post/data', [PostController::class, 'getPostData'])->name('post.getData');
    });

    // Category
    Route::resource('category', CategoryController::class);
    Route::group(['prefix' => 'category/api'], function (){
        Route::delete('delete/multiple', [CategoryController::class, 'deleteMultipleRecord'])->name('category.deleteMultipleRecord');
        Route::get('get/category/data', [CategoryController::class, 'getCategoryData'])->name('category.getData');
        Route::get('get/category', [CategoryController::class, 'getCategoryList'])->name('category.getCategoryList');
    });
});