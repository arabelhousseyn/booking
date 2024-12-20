<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * @method static static TECHNICAL_CONTROL()
 * @method static static INSURANCE()
 * @method static static GREY_CARD()
 */
final class VehicleDocumentType extends Enum implements LocalizedEnum
{
    const TECHNICAL_CONTROL = 'technical_control';
    const INSURANCE = 'insurance';
    const GREY_CARD = 'grey_card';
}
