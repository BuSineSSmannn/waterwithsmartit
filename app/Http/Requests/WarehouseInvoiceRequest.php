<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WarehouseInvoiceRequest extends FormRequest
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
            'warehouse_invoices.store',
            'warehouse_invoices.update' =>  [
                'branch_id' => ['required', 'exists:branches,id'],
                'comment' => ['sometimes', 'string'],
                'items' => ['required', 'array', 'min:1'],
                'items.*.stock_id' => [
                    'required',
                    'distinct',
                    'integer',
                    'min:1',
                    'exists:stock,id,deleted_at,NULL'
                ],
                'items.*.quantity' => ['required', 'integer', 'min:1'],
            ]
        };
    }
}
