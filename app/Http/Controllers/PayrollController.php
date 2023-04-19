<?php

namespace App\Http\Controllers;

use App\Models\CheckinCheckout;
use App\Models\CompanySetting;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PayrollController extends Controller
{

    // Attendance Overview
    public function payroll()
    {
        if (!Auth::user()->can('view_payroll')) {
            abort(403, 'Unauthorized Action');
        }

        return view('payroll.payroll');

    }

    public function payrollTable(Request $request)
    {
        if (!Auth::user()->can('view_payroll')) {
            abort(403, 'Unauthorized Action');
        }
        $month = $request->month;
        $year = $request->year;

        $startOfMonth = $year . '-' . $month . '-01';
        $endOfMonth = Carbon::parse($startOfMonth)->endOfMonth()->format('Y-m-d');
        $dayInMonth = Carbon::parse($startOfMonth)->daysInMonth;
        $workingDays = Carbon::parse($startOfMonth)->subDay(1)->diffInDaysFiltered(function (Carbon $date) {
            return $date->isWeekday();
        }, $endOfMonth);
        $offDays = $dayInMonth - $workingDays;

        $employees = User::orderBy('employee_id')->where('name', 'like', '%' . $request->employee_name . '%')->get();
        $company_setting = CompanySetting::findOrFail(1);
        $periods = new CarbonPeriod($startOfMonth, $endOfMonth);
        $attendances = CheckinCheckout::whereMonth('date', $month)->whereYear('date', $year)->get();

        return view('components.payroll_table', compact('employees', 'dayInMonth', 'company_setting', 'periods', 'attendances', 'workingDays', 'offDays', 'month', 'year'));

    }
}