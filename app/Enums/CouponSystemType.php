<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * @method static static VEHICLE()
 * @method static static HOUSE()
 * @method static static ALL()
 */
class CouponSystemType extends Enum implements LocalizedEnum
{
    const VEHICLE = 'vehicle';
    const HOUSE = 'house';
    const ALL = 'all';
}
