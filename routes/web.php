<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\PageSettingController;
use App\Http\Controllers\Admin\JoinOurNetworkController;
use App\Http\Controllers\Admin\PublicController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\MentorController;
use App\Http\Controllers\Admin\CategoryController;

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
    return Inertia::render('Front/Home');
})->name('home');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/auth.php';

Route::group(['prefix' => 'public/api'], function () {
    Route::get('get/cover/data', [PublicController::class, 'getCoverData'])->name('public.getCoverData');
    Route::get('get/page-settings/data', [PublicController::class, 'getPageSettingData'])->name('public.getPageSettingData');
    Route::get('get/join-us/data', [PublicController::class, 'getJoinUsData'])->name('public.getJoinUsData');
    Route::get('get/feature/data', [PublicController::class, 'getFeatureData'])->name('public.getFeatureData');
    Route::get('get/about-us-text/data', [PublicController::class, 'getAboutUsTextData'])->name('public.getAboutUsTextData');
    Route::get('get/about-us-card/data', [PublicController::class, 'getAboutUsCardData'])->name('public.getAboutUsCardData');
    Route::get('get/mission/data', [PublicController::class, 'getOurMissionData'])->name('public.getOurMissionData');
});

// Join Our Networks
Route::post('/join-our-networks', [JoinOurNetworkController::class, 'store'])->name('join-our-networks.store');

Route::group([
    'prefix' => 'admin',
    'middleware' => ['auth'],
], function () {

    Route::group(['prefix' => 'api'], function () {
        Route::get('get/menusidebar/permissions', [AuthenticatedSessionController::class, 'getMenuSideBarPermission'])->name('menusidebar.getPermissions');
    });

    // Page Settings
    Route::resource('/page-settings', PageSettingController::class)->except(['show', 'create', 'store', 'destroy']);

    // Join Our Networks
    Route::resource('/join-our-networks', JoinOurNetworkController::class)->except(['create', 'store', 'update', 'edit', 'destroy']);
    Route::group(['prefix' => 'join-our-networks/api'], function () {
        Route::get('get/our-network/data', [JoinOurNetworkController::class, 'getOurNetworkData'])->name('join-our-networks.getData');
    });

    // Profile Setting
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // User
    Route::resource('user', UserController::class);
    Route::group(['prefix' => 'user/api'], function () {
        Route::delete('delete/multiple', [UserController::class, 'deleteMultipleRecord'])->name('user.deleteMultipleRecord');
        Route::get('get/user/data', [UserController::class, 'getUserData'])->name('user.getData');
    });

    // Role
    Route::resource('role', RoleController::class);
    Route::group(['prefix' => 'role/api'], function () {
        Route::delete('delete/multiple', [RoleController::class, 'deleteMultipleRecord'])->name('role.deleteMultipleRecord');
        Route::get('get/role/data', [RoleController::class, 'getRoleData'])->name('role.getData');
        Route::get('get/rolelist', [RoleController::class, 'getRoleList'])->name('role.getRoleList');
    });

    // Permission
    Route::resource('permission', PermissionController::class);
    Route::group(['prefix' => 'permission/api'], function () {
        Route::delete('delete/multiple', [PermissionController::class, 'deleteMultipleRecord'])->name('permission.deleteMultipleRecord');
        Route::get('get/permission/data', [PermissionController::class, 'getPermissionData'])->name('permission.getData');
        Route::get('get/permissionlist', [PermissionController::class, 'getPermissionList'])->name('permission.getPermissionList');
    });

    // Post
    Route::resource('post', PostController::class);
    Route::group(['prefix' => 'post/api'], function () {
        Route::delete('delete/multiple', [PostController::class, 'deleteMultipleRecord'])->name('post.deleteMultipleRecord');
        Route::get('get/post/data', [PostController::class, 'getPostData'])->name('post.getData');
    });

    // Category
    Route::resource('category', CategoryController::class);
    Route::group(['prefix' => 'category/api'], function () {
        Route::delete('delete/multiple', [CategoryController::class, 'deleteMultipleRecord'])->name('category.deleteMultipleRecord');
        Route::get('get/category/data', [CategoryController::class, 'getCategoryData'])->name('category.getData');
        Route::get('get/category', [CategoryController::class, 'getCategoryList'])->name('category.getCategoryList');
        Route::get('get/category/array', [CategoryController::class, 'getCategoryArray'])->name('category.getCategoryArray');
    });

    //Mentor
    Route::resource('mentor', MentorController::class);
    Route::group(['prefix' => 'mentor/api'], function () {
        Route::delete('delete/multiple', [MentorController::class, 'deleteMultipleRecord'])->name('mentor.deleteMultipleRecord');
        Route::get('get/mentor/data', [MentorController::class, 'getMentorData'])->name('mentor.getData');
        Route::get('get/mentorlist', [MentorController::class, 'getMentorList'])->name('mentor.getMentorList');
    });
});
