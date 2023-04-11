<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployee extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {

        return [
            'employeeId' => 'required|unique:users,employee_id',
            'name' => 'required',
            'phone' => 'required|min:6|max:15|unique:users,phone',
            'nrcNumber' => 'required|unique:users,nrc_number',
            'email' => 'required|unique:users,email',
            'gender' => 'required',
            'birthday' => 'required',
            'address' => 'required|min:3',
            'department' => 'required',
            'date_of_join' => 'required',
            'profileImg' => 'mimes:jpg,png,jpeg,web',
            'is_present' => 'required',
            'pin_code' => 'required|min:6|max:6|unique:users,pin_code',
            'password' => 'required',
        ];

    }
}