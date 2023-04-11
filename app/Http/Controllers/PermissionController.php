<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\DataTables;

class PermissionController extends Controller
{
    //
    public function index()
    {
        if (!Auth::user()->can('view_permission')) {
            abort(403, 'Unauthorized Action');
        }
        return view('permission.index');
    }

    // Permission DataTable
    public function permissionDatatable(Request $request)
    {
        if (!Auth::user()->can('view_permission')) {
            abort(403, 'Unauthorized Action');
        }
        $permissions = Permission::query();

        return DataTables::of($permissions)
            ->editColumn('created_at', function ($each) {
                return $each->created_at->format('Y-m-d H:i:s');
            })
            ->editColumn('updated_at', function ($each) {
                return $each->updated_at->format('Y-m-d H:i:s');
            })
            ->addColumn('plus-icon', function ($each) {
                return null;
            })
            ->addColumn('action', function ($each) {
                $edit_icon = '';
                $delete_icon = '';

                if (Auth::user()->can('edit_permission')) {
                    $edit_icon = '<a href="' . route('permission.edit', $each->id) . '" class="text-warning"><i class="fas fa-edit"> </i> </a>';
                }

                if (Auth::user()->can('delete_permission')) {
                    $delete_icon = '<a href="#" class="text-danger delete-btn" data-id="' . $each->id . '"><i class="fa fa-trash-alt"> </i> </a>';
                }

                return '<div class="action-icon">' . $edit_icon . $delete_icon . '</div>';

            })
            ->rawColumns(['action'])
            ->make(true);
    }

    // Permission Create
    public function create()
    {
        if (!Auth::user()->can('create_permission')) {
            abort(403, 'Unauthorized Action');
        }

        return view('permission.create');
    }

    // Store Permission data
    public function store(Request $request)
    {
        if (!Auth::user()->can('create_permission')) {
            abort(403, 'Unauthorized Action');
        }

        $this->validationRule($request);
        $permission = [
            'name' => $request->name,
        ];

        Permission::create($permission);

        return redirect()->route('permission.index')->with(['createSuccess' => 'Permission Successfully create']);
    }

    // Permission Edit
    public function edit($id)
    {
        if (!Auth::user()->can('edit_permission')) {
            abort(403, 'Unauthorized Action');
        }

        $permission = Permission::findOrFail($id);
        return view('permission.edit', compact('permission'));
    }
    // Permission Update
    public function update($id, Request $request)
    {
        if (!Auth::user()->can('edit_permission')) {
            abort(403, 'Unauthorized Action');
        }

        $this->validationRule($request);
        $data = [
            'name' => $request->name,
        ];

        permission::where('id', $request->id)->update($data);
        return redirect()->route('permission.index')->with(['createSuccess' => 'Permission Successfully Update']);
    }

    // Delete Permission
    public function destroy($id)
    {
        if (!Auth::user()->can('delete_permission')) {
            abort(403, 'Unauthorized Action');
        }

        Permission::findOrFail($id)->delete();
        return 'success';
    }

    // User Validation Check
    private function validationRule($request)
    {

        Validator::make($request->all(), [
            'name' => 'required',
        ])->validate();

    }
}
