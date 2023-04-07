<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * @method static static PENDING()
 * @method static static CONFIRMED()
 * @method static static DECLINED()
 */
final class UserDocumentStatus extends Enum implements LocalizedEnum
{
    const PENDING = 'pending';
    const CONFIRMED = 'confirmed';
    const DECLINED = 'declined';
}
