<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployee extends FormRequest
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
        $id = $this->route('employee');

        return [
            'employeeId' => 'required|unique:users,employee_id,' . $id,
            'name' => 'required',
            'phone' => 'required|min:6|max:15|unique:users,phone,' . $id,
            'nrcNumber' => 'required|unique:users,nrc_number,' . $id,
            'email' => 'required|unique:users,email,' . $id,
            'gender' => 'required',
            'birthday' => 'required',
            'address' => 'required|min:3',
            'department' => 'required',
            'date_of_join' => 'required',
            'profileImg' => 'mimes:jpg,png,jpeg,web',
            'pin_code' => 'required|min:6|max:6|unique:users,pin_code,' . $id,
            'is_present' => 'required',
        ];
    }
}