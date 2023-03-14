<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * @method static static PERMANENT()
 * @method static static CUSTOM()
 */
class CouponType extends Enum implements LocalizedEnum
{
    const PERMANENT = 'permanent';
    const CUSTOM = 'custom';
}
