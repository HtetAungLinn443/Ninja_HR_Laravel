<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class MyProjectController extends Controller
{
    public function index()
    {
        return view('myproject');
    }

    // Project DataTable
    public function myProjectDatatable(Request $request)
    {

        $projects = Project::with('leaders', 'members')
            ->whereHas('leaders', function ($query) {
                $query->where('user_id', Auth::user()->id);
            })
            ->orWhereHas('members', function ($query) {
                $query->where('user_id', Auth::user()->id);
            });

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
                $info_icon = '<a href="' . route('my-project.show', $each->id) . '" class="text-primary"><i class="fa fa-info-circle"> </i> </a>';
                return '<div class="action-icon">' . $info_icon . '</div>';
            })
            ->rawColumns(['leaders', 'members', 'priority', 'status', 'action'])
            ->make(true);

    }

    // show details
    public function show($id)
    {

        $project = Project::with('leaders', 'members')->where('id', $id)
            ->where(function ($query) {
                $query->whereHas('leaders', function ($q1) {
                    $q1->where('user_id', Auth::user()->id);
                })->orWhereHas('members', function ($q1) {
                    $q1->where('user_id', Auth::user()->id);
                });
            })
            ->firstOrFail();
        return view('my_project_show', compact('project'));
    }
}
