<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * @method static static STATIC()
 * @method static static PERCENTAGE()
 */
class CouponValueType extends Enum implements LocalizedEnum
{
    const STATIC = 'static';
    const PERCENTAGE = 'percentage';
}
