<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * @method static static PENDING()
 * @method static static PUBLISHED()
 * @method static static DECLINED()
 * @method static static BOOKED()
 */
final class Status extends Enum implements LocalizedEnum
{
    const PENDING = 'pending';
    const PUBLISHED = 'published';
    const DECLINED = 'declined';
    const BOOKED = 'booked';
}
