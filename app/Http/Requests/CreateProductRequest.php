<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
            'description' => '',
            'unity' => 'required',
            'net_price' => 'required|not_in:$0',
            'iva' => 'required',
            'gross_price_with_iva' => 'required',
            'product_category_id' => 'required',
            'cost_price' => 'nullable|not_in:$0',
            'note' => '',
        ];
    }
}
