<?php

namespace App\Http\Requests;

use App\Enums\ModelType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreReviewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'reviewable_type' => ['bail', 'required', Rule::in([ModelType::HOUSE, ModelType::VEHICLE])],
            'reviewable_id' => [
                'bail', 'required', 'uuid', 'poly_exists:reviewable_type',
                Rule::unique('reviews', 'reviewable_id')->where('user_id', auth()->id())->where('reviewable_type', $this->input('reviewable_type')),
            ],
            'rating' => ['bail', 'required', 'numeric', 'between:1,5'],
        ];
    }
}
