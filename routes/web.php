<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AttendanceScanController;
use App\Http\Controllers\CheckInCheckOutController;
use App\Http\Controllers\CompanySettingController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\MyAttendanceController;
use App\Http\Controllers\MyPayrollController;
use App\Http\Controllers\MyProjectController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\TaskController;
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

    // My Attendance
    Route::get('my-attendance/datatable/ssd', [MyAttendanceController::class, 'myAttendanceDb']);
    Route::get('my-attendance-overview-table', [MyAttendanceController::class, 'attendanceOverviewTable'])->name('attendance.overview-table');

    // Attendance Overview
    Route::get('attendance-overview', [AttendanceController::class, 'attendanceOverview'])->name('attendance.overview');
    Route::get('attendance-overview-table', [AttendanceController::class, 'attendanceOverviewTable'])->name('attendance.overview-table');

    // Salary
    Route::resource('salary', SalaryController::class);
    Route::get('salary/datatable/ssd', [SalaryController::class, 'salaryDatatable'])->name('salary@datatable');

    // Payroll
    Route::get('payroll', [PayrollController::class, 'payroll'])->name('payroll');
    Route::get('payroll-table', [PayrollController::class, 'payrollTable'])->name('payroll.table');

    // My payroll
    Route::get('my-payroll/datatable/ssd', [MyPayrollController::class, 'ssd']);
    Route::get('my-payroll-table', [MyPayrollController::class, 'myPayroll']);

    // Project
    Route::resource('project', ProjectController::class);
    Route::get('project/datatable/ssd', [ProjectController::class, 'projectDatatable'])->name('project@datatable');

    // My Project
    Route::resource('my-project', MyProjectController::class)->only(['index', 'show']);
    Route::get('my-project/datatable/ssd', [MyProjectController::class, 'myProjectDatatable']);

    // Task
    Route::resource('task', TaskController::class);
    Route::get('task-data', [TaskController::class, 'taskData']);
    Route::get('task-draggable', [TaskController::class, 'taskDraggable']);
});
