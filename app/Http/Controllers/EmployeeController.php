<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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
            ->addColumn('action', function ($each) {
                $edit_icon = '<a href="' . route('employee.edit', $each->id) . '" class="text-warning"><i class="fas fa-edit"> </i> </a>';
                $info_icon = '<a href="' . route('employee.show', $each->id) . '" class="text-primary"><i class="fa fa-info-circle"> </i> </a>';

                return '<div class="action-icon">' . $edit_icon . $info_icon . '</div>';

            })
            ->rawColumns(['is_present', 'action'])
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

        $this->userValidationRile($request, $id = null, 'create');

        $userData = $this->userData($request);

        if ($request->hasFile('profileImg')) {
            $profile_image_file = $request->file('profileImg');
            $profile_image_name = uniqid() . $profile_image_file->getClientOriginalName();

            Storage::disk('public')->put('empolyee/' . $profile_image_name, file_get_contents($profile_image_file));
            $userData['image'] = $profile_image_name;
        }

        $userData['password'] = Hash::make($request->password);
        // dd($userData);
        User::create($userData);

        return redirect()->route('employee.index')->with(['createSuccess' => 'Employee Successfully create']);
    }

    // Employee Edit
    public function edit($id)
    {
        $departments = Department::orderBy('title', 'asc')->get();
        $employee = User::findOrFail($id);
        return view('employee.edit', compact('departments', 'employee'));
    }
    // Employee Update
    public function update($id, Request $request)
    {

        $this->userValidationRile($request, $id, 'update');
        $data = $this->userData($request);
        $oldPassword = User::where("id", $id)->first();
        if ($request->password != null) {
            $data['password'] = Hash::make($request->password);
        } else {
            $data['password'] = $oldPassword->password;
        }
        User::where('id', $request->id)->update($data);
        return redirect()->route('employee.index')->with(['createSuccess' => 'Employee Successfully Update']);
    }

    // User Details
    public function show($id)
    {
        $employee = User::findOrFail($id);
        return view('employee.show', compact('employee'));
    }

    // User Validation Check
    private function userValidationRile($request, $id, $action)
    {
        $validationRule = [
            'employeeId' => 'required|unique:users,employee_id,' . $id,
            'name' => 'required',
            'phone' => 'required|min:6|max:15|unique:users,phone,' . $id,
            'nrcNumber' => 'required',
            'email' => 'required|unique:users,email,' . $id,
            'gender' => 'required',
            'birthday' => 'required',
            'address' => 'required',
            'department' => 'required',
            'date_of_join' => 'required',
            'profileImg' => 'mimes:jpg,png,jpeg,web',
            'is_present' => 'required',
        ];
        $validationRule['password'] = $action == 'create' ? 'required' : '';
        Validator::make($request->all(), $validationRule)->validate();

    }

    // User Data
    private function userData($request)
    {
        return [
            'name' => $request->name,
            'email' => $request->email,
            'employee_id' => $request->employeeId,
            'phone' => $request->phone,
            'nrc_number' => $request->nrcNumber,
            'birthday' => $request->birthday,
            'gender' => $request->gender,
            'address' => $request->address,
            'department_id' => $request->department,
            'date_of_join' => $request->date_of_join,
            'image' => $request->file('profileImg'),
            'is_present' => $request->is_present,

        ];
    }
}
