<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class DepartmentController extends Controller
{
    //
    public function index()
    {
        if (!Auth::user()->can('view_department')) {
            abort(403, 'Unauthorized Action');
        }
        return view('department.index');
    }

    // Department DataTable
    public function departmentDatatable(Request $request)
    {
        if (!Auth::user()->can('view_department')) {
            abort(403, 'Unauthorized Action');
        }

        $departments = Department::query();

        return Datatables::of($departments)

            ->editColumn('updated_at', function ($each) {
                return Carbon::parse($each->updated_at)->format('Y-m-d H:i:s');
            })
            ->addColumn('plus-icon', function ($each) {
                return null;
            })
            ->addColumn('action', function ($each) {
                $edit_icon = '';
                $delete_icon = '';
                if (Auth::user()->can('edit_department')) {
                    $edit_icon = '<a href="' . route('department.edit', $each->id) . '" class="text-warning"><i class="fas fa-edit"> </i> </a>';
                }
                if (Auth::user()->can('delete_department')) {
                    $delete_icon = '<a href="#" class="text-danger delete-btn" data-id="' . $each->id . '"><i class="fa fa-trash-alt"> </i> </a>';
                }

                return '<div class="action-icon">' . $edit_icon . $delete_icon . '</div>';

            })
            ->rawColumns(['action'])
            ->make(true);

    }

    // Department Create
    public function create()
    {
        if (!Auth::user()->can('create_department')) {
            abort(403, 'Unauthorized Action');
        }

        return view('department.create');
    }

    // Store Department data
    public function store(Request $request)
    {
        if (!Auth::user()->can('create_department')) {
            abort(403, 'Unauthorized Action');
        }

        $this->validationRule($request);
        $department = [
            'title' => $request->title,
        ];

        Department::create($department);

        return redirect()->route('department.index')->with(['createSuccess' => 'Department Successfully create']);
    }

    // Department Edit
    public function edit($id)
    {
        if (!Auth::user()->can('edit_department')) {
            abort(403, 'Unauthorized Action');
        }

        $department = Department::findOrFail($id);
        return view('department.edit', compact('department'));
    }
    // Department Update
    public function update($id, Request $request)
    {
        if (!Auth::user()->can('edit_department')) {
            abort(403, 'Unauthorized Action');
        }

        $this->validationRule($request);
        $data = [
            'title' => $request->title,
        ];

        Department::where('id', $request->id)->update($data);
        return redirect()->route('department.index')->with(['createSuccess' => 'Department Successfully Update']);
    }

    // Delete Department
    public function destroy($id)
    {
        if (!Auth::user()->can('delete_department')) {
            abort(403, 'Unauthorized Action');
        }

        Department::findOrFail($id)->delete();
        return 'success';
    }

    // User Validation Check
    private function validationRule($request)
    {

        Validator::make($request->all(), [
            'title' => 'required',
        ])->validate();

    }
}
