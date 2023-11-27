<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\AuthController;

use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\DriversController;
use App\Http\Controllers\DriversAddressController;

use App\Http\Controllers\RolesController;
use App\Http\Controllers\UsersController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['prefix'=>'auth'], function(){
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);

    Route::group(['middleware'=>'auth:api'], function(){
        Route::get('logout', [AuthController::class, 'logout']);
    });
});

Route::group(['middleware'=>'auth:api'], function(){
    Route::get('permissions', [PermissionsController::class, 'index']);
    Route::get('permissions/assigned/{id}', [PermissionsController::class, 'permissionsAssignedToRole']);
    Route::post('permissions/assign', [PermissionsController::class, 'assign']);
    Route::post('permissions/design', [PermissionsController::class, 'design']);
    
    Route::post('drivers/create', [DriversController::class, 'store']);
    Route::get('drivers', [DriversController::class, 'index']);
    Route::get('drivers/{id}', [DriversController::class, 'edit']);

    Route::get('drivers/address/{id}', [DriversAddressController::class, 'edit']);
    Route::post('drivers/address/create', [DriversAddressController::class, 'store']);
    Route::put('drivers/address/{id}', [DriversAddressController::class, 'update']);


    Route::get('roles', [RolesController::class, 'index']);
    Route::get('roles/{id}', [RolesController::class, 'edit']);
    Route::post('roles', [RolesController::class, 'store']);
    Route::put('roles/{id}', [RolesController::class, 'update']);
    Route::delete('roles/{id}', [RolesController::class, 'delete']);

    Route::get('users', [UsersController::class, 'index']);
    Route::get('users/{id}', [UsersController::class, 'edit']);
    Route::post('users', [UsersController::class, 'store']);
    Route::put('users/{id}', [UsersController::class, 'update']);
    Route::delete('users/{id}', [UsersController::class, 'delete']);
    Route::patch('users/reset/password', [UsersController::class, 'resetPassword']);
});