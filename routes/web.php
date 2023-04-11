<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AttendanceScanController;
use App\Http\Controllers\CheckInCheckOutController;
use App\Http\Controllers\CompanySettingController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\MyAttendanceController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Laragear\WebAuthn\WebAuthn;

WebAuthn::routes();

Route::get('/', function () {
    return redirect()->route('login@page');
});
Route::get('checkin-checkout', [CheckInCheckOutController::class, 'checkInCheckOut'])->name('checkin-checkout@user');
Route::get('checkin-checkout/store', [CheckInCheckOutController::class, 'checkInCheckOutStore']);
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

    // Company Setting
    Route::resource('company-setting', CompanySettingController::class)->only(['edit', 'update', 'show']);

    // Attendance
    Route::resource('attendance', AttendanceController::class);
    Route::get('attendance/datatable/ssd', [AttendanceController::class, 'attendanceDatatable'])->name('attendance@datatable');

    // Attendance Scan Page
    Route::get('attendance-scan/page', [AttendanceScanController::class, 'attendanceScan'])->name("attendanceScan@admin");
    Route::get('attendance-scan/store', [AttendanceScanController::class, 'scanStore']);
    Route::get('my-attendance/datatable/ssd', [MyAttendanceController::class, 'myAttendanceDb']);
    Route::get('my-attendance-overview-table', [MyAttendanceController::class, 'attendanceOverviewTable'])->name('attendance.overview-table');

    // Attendance Overview
    Route::get('attendance-overview', [AttendanceController::class, 'attendanceOverview'])->name('attendance.overview');
    Route::get('attendance-overview-table', [AttendanceController::class, 'attendanceOverviewTable'])->name('attendance.overview-table');

});
