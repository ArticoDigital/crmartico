<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProviderRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email',
            'position' => 'required',
            'cellphone' => 'nullable|max:10',
            'phone' => '',
            'type_person' => 'required',
            'address' => 'required',
            'nit' => 'required',
            'date' => 'required|date',
            'rut' => 'nullable|mimes:pdf|max:6000',
            'chamber_commerce' => 'nullable|mimes:pdf|max:6000',
            'note' => '',
        ];
    }
}
