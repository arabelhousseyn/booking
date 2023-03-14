<?php

namespace App\Support;

use App\Enums\CouponStatus;
use App\Enums\CouponSystemType;
use App\Enums\CouponType;
use App\Enums\CouponValueType;
use App\Exceptions\CouponCodeException;
use App\Models\Coupon;
use App\Support\Contracts\Builder;
use Carbon\Carbon;

class ApplyCouponCodeBuilder implements Builder
{
    private Coupon|null $coupon;
    private float $netPrice;
    private string $applyAble;

    public function __construct(string|null $code, float $netPrice, string $applyAble)
    {
        $this->netPrice = $netPrice;
        $this->applyAble = $applyAble;

        $this->coupon = Coupon::where('code', '=', $code)->first();
    }

    public function initialize(): void
    {
        if (!blank($this->coupon)) {
            $this->resolveType();
            $this->resolveUsageLimit();
            $this->resolveStatus();
            $this->resolveApplyAble();
        }
    }

    public function calculate(): float
    {
        $this->initialize();

        if (blank($this->coupon)) {
            return $this->netPrice;
        }else{
            $this->coupon->usages()->create(['user_id' => auth()->id()]);
        }

        $calculatedPrice = 0;
        if ($this->coupon->value_type == CouponValueType::STATIC) {
            $calculatedPrice = $this->netPrice - $this->coupon->value;

        } elseif ($this->coupon->value_type == CouponValueType::PERCENTAGE) {
            $calculatedPrice = $this->netPrice - (($this->netPrice * $this->coupon->value) / 100);
        }
        return $calculatedPrice;
    }

    private function resolveType(): void
    {
        if ($this->coupon->type == CouponType::CUSTOM) {
            $now = Carbon::now();
            if (!$now->isBetween($this->coupon->start_date, $this->coupon->end_date)) {
                throw new CouponCodeException();
            }
        }
    }

    private function resolveUsageLimit(): void
    {
        if ($this->coupon->usage_limit == $this->coupon->usages()->count()) {
            throw new CouponCodeException();
        }
    }

    private function resolveStatus(): void
    {
        if ($this->coupon->status == CouponStatus::INACTIVE) {
            throw new CouponCodeException();
        }
    }

    private function resolveApplyAble(): void
    {
        if ($this->coupon->system_type->value !== $this->applyAble && $this->coupon->system_type->value !== CouponSystemType::ALL) {
            throw new CouponCodeException();
        }
    }
}
