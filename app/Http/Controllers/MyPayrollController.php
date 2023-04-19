<?php

namespace App\Http\Controllers;

use App\Models\CheckinCheckout;
use App\Models\CompanySetting;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyPayrollController extends Controller
{

    // Attendance Overview
    public function ssd()
    {

        return view('payroll.payroll');

    }

    public function myPayroll(Request $request)
    {

        $month = $request->month;
        $year = $request->year;

        $startOfMonth = $year . '-' . $month . '-01';
        $endOfMonth = Carbon::parse($startOfMonth)->endOfMonth()->format('Y-m-d');
        $dayInMonth = Carbon::parse($startOfMonth)->daysInMonth;
        $workingDays = Carbon::parse($startOfMonth)->subDay(1)->addDays(1)->diffInDaysFiltered(function (Carbon $date) {
            return $date->isWeekday();
        }, $endOfMonth);
        $offDays = $dayInMonth - $workingDays;

        $employees = User::where('id', Auth::user()->id)->orderBy('employee_id')->get();
        $company_setting = CompanySetting::findOrFail(1);
        $periods = new CarbonPeriod($startOfMonth, $endOfMonth);
        $attendances = CheckinCheckout::whereMonth('date', $month)->whereYear('date', $year)->get();

        return view('components.payroll_table', compact('employees', 'dayInMonth', 'company_setting', 'periods', 'attendances', 'workingDays', 'offDays', 'month', 'year'));

    }
}
