<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        if($this->route()?->getName() === 'products.connect_barcode_to_mxik') {
            return [
                'mxik' => ['required', 'string', 'max:255','exists:products,mxik_code'],
                'barcode' => ['required', 'string', 'max:255'],
            ];
        }

        return  [

        ];
    }
}
