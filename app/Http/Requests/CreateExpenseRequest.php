<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateExpenseRequest extends FormRequest
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
            'date' => 'required|date',
            'description' => '',
            'amount' => 'required',
            'iva' => 'required',
            'withholding_tax' => '',
            'document' => 'nullable|mimes:pdf|max:6000',
            'expense_category_id' => 'required',
            'provider_id' => 'required'
        ];
    }
}
