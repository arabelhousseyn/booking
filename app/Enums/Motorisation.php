<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * @method static static DIESEL()
 * @method static static GASOLINE()
 * @method static static GAS()
 */
final class Motorisation extends Enum implements LocalizedEnum
{
    const DIESEL = 'diesel';
    const GASOLINE = 'gasoline';
    const GAS = 'gas';
}
