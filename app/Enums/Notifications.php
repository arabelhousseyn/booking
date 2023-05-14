<?php

namespace App\Enums;

use App\Events\BookingTerminated;
use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;
use App\Notifications\BookingDeclined;

/**
 * @method static static BOOKING_DECLINED()
 * @method static static BOOKING_TERMINATED()
 */
class Notifications extends Enum implements LocalizedEnum
{
    const BOOKING_DECLINED = BookingDeclined::class;
    const BOOKING_TERMINATED = BookingTerminated::class;
}
