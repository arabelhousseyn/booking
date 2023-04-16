<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;
use App\Notifications\BookingDeclined;

/**
 * @method static static BOOKING_DECLINED()
 */
class Notifications extends Enum implements LocalizedEnum
{
    const BOOKING_DECLINED = BookingDeclined::class;
}
