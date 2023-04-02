<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\DataTables;

class PermissionController extends Controller
{
    //
    public function index()
    {
        return view('permission.index');
    }

    // Permission DataTable
    public function permissionDatatable(Request $request)
    {
        $permissions = Permission::query();

        return DataTables::of($permissions)
            ->editColumn('updated_at', function ($each) {
                return Carbon::parse($each->updated_at)->format('Y-md H:i:s');
            })
            ->addColumn('plus-icon', function ($each) {
                return null;
            })
            ->addColumn('action', function ($each) {
                $edit_icon = '<a href="' . route('permission.edit', $each->id) . '" class="text-warning"><i class="fas fa-edit"> </i> </a>';

                $delete_icon = '<a href="#" class="text-danger delete-btn" data-id="' . $each->id . '"><i class="fa fa-trash-alt"> </i> </a>';

                return '<div class="action-icon">' . $edit_icon . $delete_icon . '</div>';

            })
            ->rawColumns(['action'])
            ->make(true);
    }

    // Permission Create
    public function create()
    {
        return view('permission.create');
    }

    // Store Permission data
    public function store(Request $request)
    {
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
        $permission = Permission::findOrFail($id);
        return view('permission.edit', compact('permission'));
    }
    // Permission Update
    public function update($id, Request $request)
    {
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
