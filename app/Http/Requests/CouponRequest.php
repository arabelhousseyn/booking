<?php

namespace App\Http\Requests;

use App\Enums\CouponStatus;
use App\Enums\CouponSystemType;
use App\Enums\CouponType;
use App\Enums\CouponValueType;
use App\Models\Coupon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CouponRequest extends FormRequest
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
        $onCreateRules = [];
        $onUpdateRules = [];

        if ($this->isMethod('POST')) {
            $onCreateRules = [
                'code' => ['bail', 'required', 'max:255', Rule::unique('coupons', 'code')],
            ];
        } elseif ($this->isMethod('PUT')) {
            /** @var  Coupon $coupon */
            $coupon = $this->route('coupon');
            $onUpdateRules = [
                'code' => ['bail', 'required', 'max:255', Rule::unique('coupons', 'code')->ignoreModel($coupon)],
            ];
        }
        return [
            ...$onCreateRules,
            'description' => ['bail', 'required', 'sometimes'],
            'value_type' => ['bail', 'required', 'sometimes', Rule::in(CouponValueType::getValues())],
            'value' => ['bail', 'required', 'sometimes','numeric'],
            'type' => ['bail', 'required', 'sometimes', Rule::in(CouponType::getValues())],
            'system_type' => ['bail', 'required', 'sometimes', Rule::in(CouponSystemType::getValues())],
            'start_date' => ['bail', Rule::requiredIf($this->input('type') == CouponType::CUSTOM), 'nullable', 'sometimes', 'date'],
            'end_date' => ['bail', Rule::requiredIf($this->input('type') == CouponType::CUSTOM), 'nullable', 'sometimes', 'date'],
            'usage_limit' => ['bail', 'required', 'sometimes'],
            'status' => ['bail', 'required', 'sometimes', Rule::in(CouponStatus::getValues())],
            ...$onUpdateRules,
        ];
    }
}
