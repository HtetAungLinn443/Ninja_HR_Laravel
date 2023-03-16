<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class EmployeeController extends Controller
{
    //
    public function index()
    {
        return view('employee.index');
    }

    // Employee Data Table
    public function employeeDatatable(Request $request)
    {
        $employees = User::with('department');

        return Datatables::of($employees)
            ->addColumn('department_name', function ($each) {
                return $each->department ? $each->department->title : '-';
            })
            ->editColumn('is_present', function ($each) {
                if ($each->is_present == 1) {
                    return '<span class="badge badge-pill badge-success">Present</span>';
                } else {
                    return '<span class="badge badge-pill badge-danger">Leave</span>';
                }
            })
            ->editColumn('updated_at', function ($each) {
                return Carbon::parse($each->updated_at)->format('Y-md H:i:s');
            })
            ->addColumn('plus-icon', function ($each) {
                return null;
            })
            ->rawColumns(['is_present'])
            ->make(true);

    }

    // Employee Create
    public function create()
    {
        $departments = Department::orderBy('title', 'asc')->get();
        return view('employee.create', compact('departments'));
    }

    // Store Employee data
    public function store(Request $request)
    {
        $this->userValidationRile($request);
        $userData = $this->userData($request);

        // dd($userData);
        User::create($userData);
        return redirect()->route('employee.index')->with(['createSuccess' => 'Employee Successfully create']);
    }

    private function userValidationRile($request)
    {
        Validator::make($request->all(), [
            'employeeId' => 'required',
            'name' => 'required',
            'phone' => 'required|min:6|max:15|unique:users,phone',
            'nrcNumber' => 'required',
            'email' => 'required|unique:users,email',
            'gender' => 'required',
            'birthday' => 'required',
            'address' => 'required',
            'department' => 'required',
            'date_of_join' => 'required',
            'is_present' => 'required',
            'password' => 'required',
        ])->validate();

    }

    private function userData($request)
    {
        return [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'employee_id' => $request->employeeId,
            'phone' => $request->phone,
            'nrc_number' => $request->nrcNumber,
            'birthday' => $request->birthday,
            'gender' => $request->gender,
            'address' => $request->address,
            'department_id' => $request->department,
            'date_of_join' => $request->date_of_join,
            'is_present' => $request->is_present,

        ];
    }
}
