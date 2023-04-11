<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAttendance;
use App\Http\Requests\UpdateAttendance;
use App\Models\CheckinCheckout;
use App\Models\CompanySetting;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class AttendanceController extends Controller
{
    //
    public function index()
    {
        if (!Auth::user()->can('view_attendance')) {
            abort(403, 'Unauthorized Action');
        }
        return view('attendance.index');
    }

    // Attendance DataTable
    public function attendanceDatatable(Request $request)
    {
        if (!Auth::user()->can('view_attendance')) {
            abort(403, 'Unauthorized Action');
        }

        $attendances = CheckinCheckout::with('employee');

        return Datatables::of($attendances)
            ->filterColumn('employee_name', function ($query, $keyword) {
                $query->whereHas('employee', function ($q1) use ($keyword) {
                    $q1->where('name', 'like', '%' . $keyword . '%');
                });
            })
            ->addColumn('employee_name', function ($each) {
                return $each->employee ? $each->employee->name : '-';
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
                if (Auth::user()->can('edit_attendance')) {
                    $edit_icon = '<a href="' . route('attendance.edit', $each->id) . '" class="text-warning"><i class="fas fa-edit"> </i> </a>';
                }
                if (Auth::user()->can('delete_attendance')) {
                    $delete_icon = '<a href="#" class="text-danger delete-btn" data-id="' . $each->id . '"><i class="fa fa-trash-alt"> </i> </a>';
                }

                return '<div class="action-icon">' . $edit_icon . $delete_icon . '</div>';

            })
            ->rawColumns(['action'])
            ->make(true);

    }

    // Attendance Create
    public function create()
    {
        if (!Auth::user()->can('create_attendance')) {
            abort(403, 'Unauthorized Action');
        }
        $employees = User::orderBy('employee_id')->get();
        return view('attendance.create', compact('employees'));
    }

    // Store Attendance data
    public function store(StoreAttendance $request)
    {
        if (!Auth::user()->can('create_attendance')) {
            abort(403, 'Unauthorized Action');
        }

        if (CheckinCheckout::where('user_id', $request->user_id)->where('date', $request->date)->exists()) {
            return back()->withErrors(['fail' => 'Already defined!'])->withInput();
        }
        $attendance = [
            'user_id' => $request->user_id,
            'date' => $request->date,
            'checkin_time' => $request->date . ' ' . $request->checkin_time,
            'checkout_time' => $request->date . ' ' . $request->checkout_time,
        ];

        CheckinCheckout::create($attendance);

        return redirect()->route('attendance.index')->with(['createSuccess' => 'Attendance Successfully create']);
    }

    // Attendance Edit
    public function edit($id)
    {
        if (!Auth::user()->can('edit_attendance')) {
            abort(403, 'Unauthorized Action');
        }
        $employees = User::orderBy('employee_id')->get();

        $attendance = CheckinCheckout::findOrFail($id);
        return view('attendance.edit', compact('attendance', 'employees'));
    }
    // Attendance Update
    public function update($id, UpdateAttendance $request)
    {
        if (!Auth::user()->can('edit_attendance')) {
            abort(403, 'Unauthorized Action');
        }
        $attendance = CheckinCheckout::findOrFail($id);
        if (CheckinCheckout::where('user_id', $request->user_id)->where('date', $request->date)->where('id', '!=', $attendance->id)->exists()) {
            return back()->withErrors(['fail' => 'Already defined!'])->withInput();
        }

        $data = [
            'user_id' => $request->user_id,
            'date' => $request->date,
            'checkin_time' => $request->date . ' ' . $request->checkin_time,
            'checkout_time' => $request->date . ' ' . $request->checkout_time,
        ];

        CheckinCheckout::where('id', $request->id)->update($data);
        return redirect()->route('attendance.index')->with(['createSuccess' => 'Attendance Successfully Update']);
    }

    // Delete Attendance
    public function destroy($id)
    {
        if (!Auth::user()->can('delete_attendance')) {
            abort(403, 'Unauthorized Action');
        }

        CheckinCheckout::findOrFail($id)->delete();
        return 'success';
    }

    // Attendance Overview
    public function attendanceOverview()
    {
        if (!Auth::user()->can('view_attendance_overview')) {
            abort(403, 'Unauthorized Action');
        }

        return view('attendance.overview');
    }

    public function attendanceOverviewTable(Request $request)
    {
        if (!Auth::user()->can('view_attendance_overview')) {
            abort(403, 'Unauthorized Action');
        }
        $month = $request->month;
        $year = $request->year;

        $startOfMonth = $year . '-' . $month . '-01';
        $endOfMonth = Carbon::parse($startOfMonth)->endOfMonth()->format('Y-m-d');

        $employees = User::orderBy('employee_id')->where('name', 'like', '%' . $request->employee_name . '%')->get();
        $company_setting = CompanySetting::findOrFail(1);
        $periods = new CarbonPeriod($startOfMonth, $endOfMonth);
        $attendances = CheckinCheckout::whereMonth('date', $month)->whereYear('date', $year)->get();

        return view('components.attendance_overview_table', compact('employees', 'company_setting', 'periods', 'attendances'));

    }

}
