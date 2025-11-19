<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\DiserIdNumber;

class DiserIdNumberEditRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->can('diser id number edit');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'diser_number' => [
                'required',
                Rule::unique((new DiserIdNumber)->getTable(), 'id_number')->ignore(decrypt($this->id))
            ],
            'area' => [
                'required'
            ],
        ];
    }
}
