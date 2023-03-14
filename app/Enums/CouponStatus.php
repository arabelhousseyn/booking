<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * @method static static ACTIVE()
 * @method static static INACTIVE()
 */
class CouponStatus extends Enum implements LocalizedEnum
{
    const ACTIVE = 'active';
    const INACTIVE = 'inactive';
}
