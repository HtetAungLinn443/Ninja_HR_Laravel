<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class RoleController extends Controller
{
    //
    public function index()
    {
        if (!Auth::user()->can('view_role')) {
            abort(403, 'Unauthorized Action');
        }
        return view('role.index');
    }

    // Role DataTable
    public function roleDatatable(Request $request)
    {
        if (!Auth::user()->can('view_role')) {
            abort(403, 'Unauthorized Action');
        }

        $roles = Role::query();

        return DataTables::of($roles)
            ->addColumn('permissions', function ($each) {
                $output = '';
                foreach ($each->permissions as $permission) {
                    $output .= '<span class="badge badge-primary rounded-pill badge- m-1">' . $permission->name . '</span>';
                }
                return $output;
            })
            ->editColumn('updated_at', function ($each) {
                return Carbon::parse($each->updated_at)->format('Y-md H:i:s');
            })
            ->addColumn('plus-icon', function ($each) {
                return null;
            })

            ->addColumn('action', function ($each) {
                $edit_icon = '';
                $delete_icon = '';
                if (Auth::user()->can('edit_role')) {
                    $edit_icon = '<a href="' . route('role.edit', $each->id) . '" class="text-warning"><i class="fas fa-edit"> </i> </a>';
                }

                if (Auth::user()->can('delete_role')) {
                    $delete_icon = '<a href="#" class="text-danger delete-btn" data-id="' . $each->id . '"><i class="fa fa-trash-alt"> </i> </a>';
                }
                return '<div class="action-icon">' . $edit_icon . $delete_icon . '</div>';

            })
            ->rawColumns(['action', 'permissions'])
            ->make(true);
    }

    // Role Create
    public function create()
    {
        if (!Auth::user()->can('create_role')) {
            abort(403, 'Unauthorized Action');
        }

        $permissions = Permission::all();
        return view('role.create', compact('permissions'));
    }

    // Store Role data
    public function store(Request $request)
    {
        if (!Auth::user()->can('create_role')) {
            abort(403, 'Unauthorized Action');
        }

        $this->validationRule($request);
        $role = Role::create([
            'name' => $request->name,
        ]);
        $role->givePermissionTo($request->permission);

        return redirect()->route('role.index')->with(['createSuccess' => 'Role Successfully create']);
    }
    // Role Edit
    public function edit($id)
    {
        if (!Auth::user()->can('edit_role')) {
            abort(403, 'Unauthorized Action');
        }

        $permissions = Permission::all();
        $role = Role::findOrFail($id);
        $old_permissions = $role->permissions->pluck('id')->toArray();
        return view('role.edit', compact('role', 'permissions', 'old_permissions'));
    }
    // Role Update
    public function update(Request $request)
    {
        if (!Auth::user()->can('edit_role')) {
            abort(403, 'Unauthorized Action');
        }

        $this->validationRule($request);
        Role::where('id', $request->id)->update([
            'name' => $request->name,
        ]);
        $role = Role::findOrFail($request->id);

        $old_permission = $role->permissions;

        $role->revokePermissionTo($old_permission);
        $role->givePermissionTo($request->permission);

        return redirect()->route('role.index')->with(['createSuccess' => 'Role Successfully Update']);
    }

    // Delete Role
    public function destroy($id)
    {
        if (!Auth::user()->can('delete_role')) {
            abort(403, 'Unauthorized Action');
        }

        Role::findOrFail($id)->delete();
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
