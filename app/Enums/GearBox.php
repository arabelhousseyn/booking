<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static MANUAL()
 * @method static static AUTOMATIC()
 */
final class GearBox extends Enum
{
    const MANUAL = 'manual';
    const AUTOMATIC = 'automatic';
}
