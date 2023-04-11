<?php

namespace App\Http\Controllers;

use App\Models\CheckinCheckout;
use App\Models\CompanySetting;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class MyAttendanceController extends Controller
{
    // My Attendance Datatable
    public function myAttendanceDb(Request $request)
    {

        $attendances = CheckinCheckout::with('employee')->where('user_id', Auth::user()->id);
        if ($request->month) {
            $attendances = $attendances->whereMonth('date', $request->month);
        }
        if ($request->year) {
            $attendances = $attendances->whereYear('date', $request->year);
        }

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
            ->make(true);

    }

    // Attendance overview
    public function attendanceOverviewTable(Request $request)
    {

        $month = $request->month;
        $year = $request->year;

        $startOfMonth = $year . '-' . $month . '-01';
        $endOfMonth = Carbon::parse($startOfMonth)->endOfMonth()->format('Y-m-d');

        $employees = User::where('id', Auth::user()->id)->get();
        $company_setting = CompanySetting::findOrFail(1);
        $periods = new CarbonPeriod($startOfMonth, $endOfMonth);
        $attendances = CheckinCheckout::whereMonth('date', $month)->whereYear('date', $year)->get();

        return view('components.attendance_overview_table', compact('employees', 'company_setting', 'periods', 'attendances'));

    }

}
