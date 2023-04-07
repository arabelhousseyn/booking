<?php

namespace App\Http\Requests;

use App\Enums\UserDocumentType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserDocumentRequest extends FormRequest
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
            'documents' => ['bail', 'required', 'array'],
            'documents.*.document_type' => [
                'bail', 'required',
                Rule::in([UserDocumentType::ID, UserDocumentType::PASSPORT, UserDocumentType::FACE, UserDocumentType::DOCUMENT_LICENSE_FRONT, UserDocumentType::DOCUMENT_LICENSE_BACK]),
            ],
            'documents.*.document_image' => ['bail', 'required', 'image', 'mimes:jpg,jpeg,png'],
        ];
    }
}
