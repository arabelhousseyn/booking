<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * @method static static PENDING()
 * @method static static ACCEPTED()
 * @method static static COMPLETED()
 * @method static static DECLINED()
 */
class BookingStatus extends Enum implements LocalizedEnum
{
    const PENDING = 'pending';
    const ACCEPTED = 'accepted';
    const COMPLETED = 'completed';
    const DECLINED = 'declined';
}
