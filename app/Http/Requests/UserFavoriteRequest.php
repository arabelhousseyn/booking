<?php

namespace App\Http\Requests;

use App\Enums\ModelType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserFavoriteRequest extends FormRequest
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
        $user = auth('web')->user();
        return [
            'favorable_type' => ['bail', 'required', Rule::in([ModelType::VEHICLE, ModelType::HOUSE])],
            'favorable_id' => ['bail', 'required','poly_exists:favorable_type','uuid'],
        ];
    }
}
