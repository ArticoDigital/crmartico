<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateInvoiceRequest extends FormRequest
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
            'number' => 'required',
            'note' => '',
            'payment_conditions' => 'required',
            'due_date' => 'required|date',
            'terms' => '',
            'address' => 'required',
            'status_id' => '',
            'customer_id' => 'required',
            'product.*.product_id' => 'required',
            'product.*.quantity' => 'required|min:1',
            'product.*.discount' => 'required',
            'product.*.net_price' => 'required|not_in:$0',
            'product.*.iva' => 'required',
            'product.*.description' => '',
            'product.*.price_temp' => 'required',
            'product.*.withholding_tax' => '',
        ];
    }
}
