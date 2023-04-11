<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class EmployeeController extends Controller
{
    //
    public function index()
    {
        if (!Auth::user()->can('view_employee')) {
            abort(403, 'Unauthorized Action');
        }
        return view('employee.index');
    }

    // Employee Data Table
    public function employeeDatatable(Request $request)
    {
        if (!Auth::user()->can('view_employee')) {
            abort(403, 'Unauthorized Action');
        }

        $employees = User::with('department');

        return Datatables::of($employees)
            ->filterColumn('department_name', function ($query, $keyword) {
                $query->whereHas('department', function ($q1) use ($keyword) {
                    $q1->where('title', 'like', '%' . $keyword . '%');
                });
            })
            ->editColumn('profile_img', function ($each) {
                return '<img src="' . $each->profile_img_path() . '" class="profile-thumbnail" alt=""><p class="my-1">' . $each->name . '</p>';
            })
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
                $edit_icon = '';
                $info_icon = '';
                $delete_icon = "";
                if (Auth::user()->can('edit_employee')) {
                    $edit_icon = '<a href="' . route('employee.edit', $each->id) . '" class="text-warning"><i class="fas fa-edit"> </i> </a>';
                }
                if (Auth::user()->can('view_employee')) {
                    $info_icon = '<a href="' . route('employee.show', $each->id) . '" class="text-primary"><i class="fa fa-info-circle"> </i> </a>';
                }
                if (Auth::user()->can('delete_employee')) {
                    $delete_icon = '<a href="#" class="text-danger delete-btn" data-id="' . $each->id . '"><i class="fa fa-trash-alt"> </i> </a>';
                }
                return '<div class="action-icon">' . $edit_icon . $info_icon . $delete_icon . '</div>';

            })
            ->addColumn('roles', function ($each) {
                $output = '';
                foreach ($each->roles as $role) {
                    $output .= '<span class="badge rounded-pill badge-primary m-1">' . $role->name . '</span>';
                }
                return $output;
            })
            ->rawColumns(['profile_img', 'is_present', 'action', 'roles'])
            ->make(true);

    }

    // Employee Create
    public function create()
    {
        if (!Auth::user()->can('create_employee')) {
            abort(403, 'Unauthorized Action');
        }

        $departments = Department::orderBy('title', 'asc')->get();
        $roles = Role::all();
        return view('employee.create', compact('departments', 'roles'));
    }

    // Store Employee data
    public function store(Request $request)
    {
        if (!Auth::user()->can('create_employee')) {
            abort(403, 'Unauthorized Action');
        }

        $this->userValidationRule($request, $id = null, 'create');

        $userData = [
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
            'is_present' => $request->is_present,
            'pin_code' => $request->pin_code,
            'password' => Hash::make($request->password),
        ];
        if ($request->hasFile('profileImg')) {
            $profile_image_file = $request->file('profileImg');
            $profile_image_name = uniqid() . $profile_image_file->getClientOriginalName();

            Storage::disk('public')->put('employee/' . $profile_image_name, file_get_contents($profile_image_file));
            $userData['image'] = $profile_image_name;
        }

        $user = User::create($userData);
        $user->syncRoles($request->roles);

        return redirect()->route('employee.index')->with(['createSuccess' => 'Employee Successfully create']);
    }

    // Employee Edit
    public function edit($id)
    {
        if (!Auth::user()->can('edit_employee')) {
            abort(403, 'Unauthorized Action');
        }

        $departments = Department::orderBy('title', 'asc')->get();
        $employee = User::findOrFail($id);
        $old_roles = $employee->roles->pluck('id')->toArray();
        $roles = Role::all();
        return view('employee.edit', compact('departments', 'employee', 'old_roles', 'roles'));
    }
    // Employee Update
    public function update($id, Request $request)
    {
        if (!Auth::user()->can('edit_employee')) {
            abort(403, 'Unauthorized Action');
        }

        $this->userValidationRule($request, $id, 'update');

        $data = [
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
            'is_present' => $request->is_present,
            'pin_code' => $request->pin_code,
        ];
        $employee = User::where("id", $id)->first();
        if ($request->password != null) {
            $data['password'] = Hash::make($request->password);
        } else {
            $data['password'] = $employee->password;
        }

        if ($request->hasFile('profileImg')) {

            Storage::disk('public')->delete('employee/' . $employee->image);
            $profile_image_file = $request->file('profileImg');
            $profile_image_name = uniqid() . $profile_image_file->getClientOriginalName();

            Storage::disk('public')->put('employee/' . $profile_image_name, file_get_contents($profile_image_file));
            $data['image'] = $profile_image_name;
        }

        User::where('id', $request->id)->update($data);
        $user = User::findOrFail($request->id);
        $user->syncRoles($request->roles);

        return redirect()->route('employee.index')->with(['createSuccess' => 'Employee Successfully Update']);
    }

    // User Details
    public function show($id)
    {
        if (!Auth::user()->can('view_employee')) {
            abort(403, 'Unauthorized Action');
        }

        $employee = User::findOrFail($id);
        return view('employee.show', compact('employee'));
    }

    // Delete Employee
    public function destroy($id)
    {
        if (!Auth::user()->can('delete_employee')) {
            abort(403, 'Unauthorized Action');
        }

        User::findOrFail($id)->delete();
        return 'success';
    }

    // User Validation Check
    private function userValidationRule($request, $id, $action)
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
}
