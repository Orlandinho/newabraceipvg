<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'max:60'],
            'dob' => ['required','date_format:Y-m-d','before_or_equal:' . now()->format('Y-m-d')],
            'email' => ['nullable', 'email'],
            'zipcode' => ['min:8', 'max:8', 'required'],
            'street' => ['required', 'max:255'],
            'region' => ['required', 'max:255'],
            'city' => ['required', 'max:255']
        ];
    }
}
