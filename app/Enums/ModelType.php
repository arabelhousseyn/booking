<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * @method static static HOUSE()
 * @method static static VEHICLE()
 */
final class ModelType extends Enum implements LocalizedEnum
{
    const HOUSE = 'house';
    const VEHICLE = 'vehicle';
}
