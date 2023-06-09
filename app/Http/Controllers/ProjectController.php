<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProject;
use App\Models\Project;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class ProjectController extends Controller
{
    //
    public function index()
    {
        if (!Auth::user()->can('view_project')) {
            abort(403, 'Unauthorized Action');
        }
        return view('project.index');
    }

    // Project DataTable
    public function projectDatatable(Request $request)
    {
        if (!Auth::user()->can('view_project')) {
            abort(403, 'Unauthorized Action');
        }

        $projects = Project::with('leaders', 'members', 'tasks');

        return Datatables::of($projects)
            ->editColumn('description', function ($each) {
                return Str::limit($each->description, 100);
            })
            ->addColumn('leaders', function ($each) {
                $output = '<div style="width:160px">';
                foreach ($each->leaders as $leader) {
                    $output .= '<img src="' . $leader->profile_img_path() . '" class="profile-thumbnail2">';
                }
                return $output . '</div>';
            })
            ->addColumn('members', function ($each) {
                $output = '<div style="width:160px">';
                foreach ($each->members as $member) {
                    $output .= '<img src="' . $member->profile_img_path() . '" class="profile-thumbnail2">';
                }
                return $output . '</div>';

            })
            ->editColumn('priority', function ($each) {
                if ($each->priority == 'height') {
                    return '<span class="badge badge-pill badge-rounded badge-danger">Height</span>';
                } else if ($each->priority == 'middle') {
                    return '<span class="badge badge-pill badge-rounded badge-info">Middle</span>';
                } else if ($each->priority == 'low') {
                    return '<span class="badge badge-pill badge-rounded badge-dark">Low</span>';
                }
            })
            ->editColumn('status', function ($each) {
                if ($each->status == 'pending') {
                    return '<span class="badge badge-pill badge-rounded badge-warning">Pending</span>';
                } else if ($each->status == 'in_progress') {
                    return '<span class="badge badge-pill badge-rounded badge-info">In Progress</span>';
                } else if ($each->status == 'complete') {
                    return '<span class="badge badge-pill badge-rounded badge-success">Complete</span>';
                }
            })
            ->editColumn('updated_at', function ($each) {
                return Carbon::parse($each->updated_at)->format('Y-m-d H:i:s');
            })
            ->addColumn('plus-icon', function ($each) {
                return null;
            })
            ->addColumn('action', function ($each) {
                $info_icon = '';
                $edit_icon = '';
                $delete_icon = '';
                if (Auth::user()->can('view_project')) {
                    $info_icon = '<a href="' . route('project.show', $each->id) . '" class="text-primary"><i class="fa fa-info-circle"> </i> </a>';
                }

                if (Auth::user()->can('edit_project')) {
                    $edit_icon = '<a href="' . route('project.edit', $each->id) . '" class="text-warning"><i class="fas fa-edit"> </i> </a>';
                }
                if (Auth::user()->can('delete_project')) {
                    $delete_icon = '<a href="#" class="text-danger delete-btn" data-id="' . $each->id . '"><i class="fa fa-trash-alt"> </i> </a>';
                }

                return '<div class="action-icon">' . $edit_icon . $delete_icon . $info_icon . '</div>';

            })
            ->rawColumns(['leaders', 'members', 'priority', 'status', 'action'])
            ->make(true);

    }

    // Project Create
    public function create()
    {
        if (!Auth::user()->can('create_project')) {
            abort(403, 'Unauthorized Action');
        }
        $employees = User::orderBy('name')->get();
        return view('project.create', compact('employees'));
    }

    // Store Project data
    public function store(StoreProject $request)
    {
        if (!Auth::user()->can('create_project')) {
            abort(403, 'Unauthorized Action');
        }
        $this->validationRule($request);

        $image_names = null;
        if ($request->hasFile('images')) {
            $image_names = [];
            $images_file = $request->file('images');
            foreach ($images_file as $image_file) {
                $file = file($image_file);
                $image_name = uniqid() . '-' . time() . '.' . $image_file->getClientOriginalExtension();
                Storage::disk('public')->put('project/image/' . $image_name, file_get_contents($image_file));
                $image_names[] = $image_name;
            }

        }

        $file_names = null;
        if ($request->hasFile('files')) {
            $file_names = [];
            $files = $request->file('files');
            foreach ($files as $file) {
                $file_name = uniqid() . '-' . time() . '.' . $file->getClientOriginalExtension();
                Storage::disk('public')->put('project/pdf/' . $file_name, file_get_contents($file));
                $file_names[] = $file_name;
            }
        }

        $project = new Project();
        $project->title = $request->title;
        $project->description = $request->description;
        $project->image = $image_names;
        $project->files = $file_names;
        $project->start_of_date = $request->startDate;
        $project->deatline = $request->deadline;
        $project->priority = $request->priority;
        $project->status = $request->status;
        $project->save();

        $project->leaders()->sync($request->leaders);
        $project->members()->sync($request->members);

        return redirect()->route('project.index')->with(['createSuccess' => 'Project Successfully create']);
    }

    // Project Edit
    public function edit($id)
    {
        if (!Auth::user()->can('edit_project')) {
            abort(403, 'Unauthorized Action');
        }

        $project = Project::findOrFail($id);
        $employees = User::orderBy('name')->get();
        return view('project.edit', compact('project', 'employees'));
    }

    // Project Update
    public function update($id, Request $request)
    {
        if (!Auth::user()->can('edit_project')) {
            abort(403, 'Unauthorized Action');
        }
        $this->validationRule($request);
        $project = Project::findOrFail($id);
        $image_names = $project->image;
        if ($request->hasFile('images')) {
            $image_names = [];
            $images_file = $request->file('images');
            foreach ($images_file as $image_file) {
                $file = file($image_file);
                $image_name = uniqid() . '-' . time() . '.' . $image_file->getClientOriginalExtension();
                Storage::disk('public')->put('project/image/' . $image_name, file_get_contents($image_file));
                $image_names[] = $image_name;
            }

        }

        $file_names = $project->files;
        if ($request->hasFile('files')) {
            $file_names = [];
            $files = $request->file('files');
            foreach ($files as $file) {
                $file_name = uniqid() . '-' . time() . '.' . $file->getClientOriginalExtension();
                Storage::disk('public')->put('project/pdf/' . $file_name, file_get_contents($file));
                $file_names[] = $file_name;
            }
        }

        $project->title = $request->title;
        $project->description = $request->description;
        $project->image = $image_names;
        $project->files = $file_names;
        $project->start_of_date = $request->startDate;
        $project->deatline = $request->deadline;
        $project->priority = $request->priority;
        $project->status = $request->status;
        $project->update();

        $project->leaders()->sync($request->leaders);
        $project->members()->sync($request->members);

        return redirect()->route('project.index')->with(['createSuccess' => 'Project Successfully Update']);
    }

    // Delete Project
    public function destroy($id)
    {
        if (!Auth::user()->can('delete_project')) {
            abort(403, 'Unauthorized Action');
        }

        $project = Project::findOrFail($id);

        $project->leaders()->detach();
        $project->members()->detach();

        $project->delete();
        return 'success';
    }

    // User Validation Check
    private function validationRule($request)
    {

        Validator::make($request->all(), [
            'title' => 'required',
            'startDate' => 'required',
            'deadline' => 'required',
            'priority' => 'required',
            'status' => 'required',
        ])->validate();

    }

    public function show($id)
    {
        if (!Auth::user()->can('view_project')) {
            abort(403, 'Unauthorized Action');
        }
        $project = Project::findOrFail($id);
        return view('project.show', compact('project'));
    }
}
