<?php

namespace App\Http\Controllers;

use App\Models\CheckinCheckout;
use App\Models\CompanySetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CheckInCheckOutController extends Controller
{
    //
    public function checkInCheckOut()
    {
        $company_setting = CompanySetting::findOrFail('1');
        $hash_value = Hash::make(date('Y-m-d'));

        return view('checkin_checkout', compact('hash_value'));
    }

    public function checkInCheckOutStore(Request $request)
    {
        if (now()->format('D') == 'Sat' || now()->format('D') == 'Sun') {
            return [
                'status' => 'fail',
                'message' => 'Today is Off Day.',
            ];

        }

        $user = User::where('pin_code', $request->pin_code)->first();
        if (!$user) {
            return [
                'status' => 'fail',
                'message' => 'Pin Code is wrong!',
            ];

        }

        $checkin_checkout_data = CheckinCheckout::firstOrCreate([
            'user_id' => $user->id,
            'date' => now()->format('Y-m-d'),
        ]);

        if (!is_null($checkin_checkout_data->checkin_time) && !is_null($checkin_checkout_data->checkout_time)) {

            return [
                'status' => 'fail',
                'message' => 'Already checkin and checkout today!',
            ];

        }

        if (is_null($checkin_checkout_data->checkin_time)) {
            $checkin_checkout_data->checkin_time = now();
            $message = "Successfully check in at " . now();
        } else {
            if (is_null($checkin_checkout_data->checkout_time)) {
                $checkin_checkout_data->checkout_time = now();
                $message = "Successfully Check Out at " . now();

            }
        }

        $checkin_checkout_data->update();
        return [
            'status' => 'success',
            'message' => $message,
        ];
    }
}