<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static DIESEL()
 * @method static static GASOLINE()
 * @method static static MATZOT()
 */
final class Motorisation extends Enum
{
    const DIESEL = 'diesel';
    const GASOLINE = 'gasoline';
    const MATZOT = 'matzot';
}
