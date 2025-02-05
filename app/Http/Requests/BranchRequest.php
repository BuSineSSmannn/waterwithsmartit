<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class BranchRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $branch = $this->route('branch');

        return match ($this->route()?->getName()){
            'branches.store' => [
                'name' => 'required|string|max:255|unique:branches',
                'address' => ['sometimes','string','max:300'],
                'phone' => 'sometimes|string|max:30'
            ],
            'branches.update' => [
                'name' => 'required|string|max:255|unique:branches,name,' . $branch->id,
                'address' => ['sometimes','string','max:300'],
                'phone' => 'sometimes|string|max:30'
            ],
            default => []
        };
    }
}
