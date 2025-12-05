<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BranchEditRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'branch_code' => [
                'required'
            ],
            'branch_name' => [
                'required'
            ],
            'area_id' => [
                'required'
            ],
            'classification_id' => [
                'required'
            ],
            'region_id' => [
                'required'
            ],
            'longitude' => [
                'required'
            ],
            'latitude' => [
                'required'
            ],
            'accuracy' => [
                'required'
            ]
        ];
    }
}
