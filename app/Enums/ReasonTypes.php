<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * @method static static HOUSES()
 * @method static static VEHICLES()
 * @method static static ALL()
 */

class ReasonTypes extends Enum implements LocalizedEnum
{
    const HOUSES = 'houses';
    const VEHICLES = 'vehicles';
    const ALL = 'all';
}
