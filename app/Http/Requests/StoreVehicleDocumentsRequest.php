<?php

namespace App\Http\Requests;

use App\Enums\VehicleDocumentType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreVehicleDocumentsRequest extends FormRequest
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
            'documents' => ['bail', 'required'],
            'documents.*.document_type' => ['bail', 'required', Rule::in(VehicleDocumentType::TECHNICAL_CONTROL, VehicleDocumentType::GREY_CARD, VehicleDocumentType::INSURANCE)],
            'documents.*.document_image' => ['bail', 'required', 'image', 'mimes:jpg,jpeg,png'],
            'documents.*.expiry_date' => ['bail', 'required', 'date'],
        ];
    }
}
