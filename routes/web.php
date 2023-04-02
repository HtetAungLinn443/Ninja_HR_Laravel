<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login@page');
});
Route::get('loginPage', [UserController::class, 'loginPage'])->name('login@page');

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');

    // Employee
    Route::resource('employee', EmployeeController::class);
    Route::get('employee/datatable/ssd', [EmployeeController::class, 'employeeDatatable'])->name('employee@datatable');

    // Profile
    Route::get('profile', [ProfileController::class, 'profilePage'])->name('profile#Page');

    // Department
    Route::resource('department', DepartmentController::class);
    Route::get('department/datatable/ssd', [DepartmentController::class, 'departmentDatatable'])->name('department@datatable');

    // Role
    Route::resource('role', RoleController::class);
    Route::get('role/datatable/ssd', [RoleController::class, 'roleDatatable'])->name('role@datatable');

    // Permission
    Route::resource('permission', PermissionController::class);
    Route::get('permission/datatable/ssd', [PermissionController::class, 'permissionDatatable'])->name('permission@datatable');

});
