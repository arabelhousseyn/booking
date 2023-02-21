<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * @method static static MANUAL()
 * @method static static AUTOMATIC()
 */
final class GearBox extends Enum implements LocalizedEnum
{
    const MANUAL = 'manual';
    const AUTOMATIC = 'automatic';

}
