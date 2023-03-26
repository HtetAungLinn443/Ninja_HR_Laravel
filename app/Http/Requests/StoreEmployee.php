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
            'employeeId' => 'required',
            'name' => 'required',
            'phone' => 'required|min:6|max:15',
            'nrcNumber' => 'required',
            'email' => 'required',
            'gender' => 'required',
            'birthday' => 'required',
            'address' => 'required',
            'department' => 'required',
            'date_of_join' => 'required',
            'profileImg' => 'mimes:jpg,png,jpeg,web',
            'password' => 'required',
            'is_present' => 'required',
        ];

    }
}
