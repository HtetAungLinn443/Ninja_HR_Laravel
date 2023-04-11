<?php

namespace App\Http\Controllers;

use App\Models\CompanySetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanySettingController extends Controller
{
    // show
    public function show($id)
    {
        if (!Auth::user()->can('view_company_setting')) {
            abort(403, 'Unauthorized Action');
        }
        $setting = CompanySetting::findOrFail($id);
        return view('company_setting.show', compact('setting'));
    }

    public function edit($id)
    {
        if (!Auth::user()->can('edit_company_setting')) {
            abort(403, 'Unauthorized Action');
        }

        $setting = CompanySetting::findOrFail($id);
        return view('company_setting.edit', compact('setting'));
    }
    public function update($id, Request $request)
    {
        if (!Auth::user()->can('edit_company_setting')) {
            abort(403, 'Unauthorized Action');
        }

        $data = [
            'company_name' => $request->company_name,
            'company_email' => $request->company_email,
            'company_phone' => $request->company_phone,
            'company_address' => $request->company_address,
            'office_start_time' => $request->office_start_time,
            'office_end_time' => $request->office_end_time,
            'break_start_time' => $request->break_start_time,
            'break_end_time' => $request->break_end_time,
        ];
        CompanySetting::where('id', $id)->update($data);
        return redirect()->route('company-setting.show', 1)->with(['createSuccess' => 'Company Setting Successfully Update']);
    }
}
