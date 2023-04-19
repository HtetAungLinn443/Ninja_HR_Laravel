<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSalary extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {

        return [
            'user_id' => 'required',
            'month' => 'required',
            'year' => 'required',
            'amount' => 'required',
        ];

    }
    public function messages()
    {
        return [
            'user_id.required' => 'The Employee field is required.',
        ];
    }
}
