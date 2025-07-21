<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePassangerDetailRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama'                          => 'required',
            'email'                         => 'required',
            'nomor'                         => 'required',
            'passengers'                    => 'required|array|min:1',
            'passengers.*.nama'             => 'required',
            'passengers.*.date_of_birth'    => 'required',
            'passengers.*.kewarganeraan'    => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'passengers.*.nama'             => 'Passenger name',
            'passengers.*.date_of_birth'    => 'Passenger date of birth',
            'passengers.*.kewarganeraan'    => 'Passenger nationality',
        ];
    }

    public function messages(){
        return [
            'passengers.*.nama.required'             => 'atribute field is required',
            'passengers.*.date_of_birth.required'    => 'atribute field is required',
            'passengers.*.kewarganeraan.required'    => 'atribute field is required',
        ];
    }
}
