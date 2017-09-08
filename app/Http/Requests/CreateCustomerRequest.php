<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'c.*.name' => 'required',
            'c.*.email' => 'required|email',
            'c.*.position' => 'required|max:10',
            'c.*.cellphone' => 'required|max:10',
            'name_customer' => 'required',
            'address' => 'required',
            'nit' => 'required',
            'payment_conditions' => 'required',
            'date' => 'required|date',
            'rut' => 'nullable|mimes:pdf|max:6000',
            'chamber_commerce' => 'nullable|mimes:pdf|max:6000',
        ];
    }
    public function messages()
    {
        return [
            'message.required' => 'El mensaje es requerido',
            'message.max' => 'Mucho texto',
        ];
    }
}
