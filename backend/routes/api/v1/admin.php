<?php

use App\Api\V1\Controllers\PermissionController;
use App\Api\V1\Controllers\RoleController;
use App\Api\V1\Controllers\UserController;
use App\Api\V1\Controllers\UserTypeController;
use Illuminate\Support\Facades\Route;


Route::resources([
    'roles' => RoleController::class,
    'permissions' => PermissionController::class,
    'user-types' => UserTypeController::class,
    'users' => UserController::class,
]);

Route::get('permissions/list/group-wise', [PermissionController::class, 'groupWisePermissions'])->name('permissions.group_wise_permissions');
Route::get('roles/{role}/permissions', [RoleController::class, 'rolePermissionIndex'])->name('roles.permissions');
Route::post('roles/{role}/permissions', [RoleController::class, 'rolePermissionSync'])->name('roles.permission-sync');

Route::get('users/{user}/roles', [UserController::class, 'userRoleIndex'])->name('users.roles');
Route::post('users/{user}/roles', [UserController::class, 'userRoleSync'])->name('users.role-sync');

Route::get('users/{user}/permissions', [UserController::class, 'userPermissionIndex'])->name('users.permissions');
Route::post('users/{user}/permissions', [UserController::class, 'userPermissionSync'])->name('users.permission-sync');

