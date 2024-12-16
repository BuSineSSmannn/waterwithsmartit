<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ColorRequest extends FormRequest
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
        $color = $this->route('color');

        return match ($this->route()?->getName()){
            'colors.store' => [
                'name' => 'required|string|max:150|unique:colors',
            ],
            'colors.update' => [
                'name' => 'required|string|max:150|unique:colors,name,' . $color->id,
            ],
            default => []
        };
    }
}
