<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StockInvoiceRequest extends FormRequest
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
        return  match ($this->route()?->getName()){
            'stock_invoices.store' => [
                'supplier_id' => 'required|exists:suppliers,id,deleted_at,NULL',
                'trx_type' => 'required|in:white,black',
                'items' => 'required|array|min:1',
                'items.*.product_id' => 'required|exists:products,id,deleted_at,NULL',
                'items.*.quantity' => 'required|numeric|min:1',
                'items.*.price' => 'required|numeric|min:1',
                'items.*.sale_price' => 'required|numeric|min:1',
                'items.*.date_expire' => 'required|date|date_format:d.m.Y',

            ]
        };
    }
}
