<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SizeRequest extends FormRequest
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

       return match ($this->route()?->getName()){
            'sizes.store'=> [
                'name' => 'required|string|max:150|unique:sizes',
                'category_id' => 'required|exists:categories,id,deleted_at,NULL',
            ],

           'sizes.update'=> [
                'name' => 'required|string|max:150|unique:sizes,name,' . $this->route('size')->id,
                'category_id' => 'required|exists:categories,id,deleted_at,NULL',
            ],



           default => []
        };
    }
}
