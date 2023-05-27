<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * @method static static PENDING()
 * @method static static PAID()
 */
final class PaymentStatus extends Enum implements LocalizedEnum
{
    const PENDING = 'pending';
    const PAID = 'paid';
}
