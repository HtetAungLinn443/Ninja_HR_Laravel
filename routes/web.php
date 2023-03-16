<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login@page');
});
Route::get('loginPage', [UserController::class, 'loginPage'])->name('login@page');

Route::middleware(['auth'])->group(function () {
    Route::get('/home/page', function () {
        return view('dashboard');
    })->name('dashboard');

    // Employee
    Route::resource('employee', EmployeeController::class);
    Route::get('employee/datatable/ssd', [EmployeeController::class, 'employeeDatatable'])->name('employee@datatable');
    Route::post('employee/store', [EmployeeController::class, 'store']);
});
