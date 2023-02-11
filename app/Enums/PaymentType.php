<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static DAHABIA()
 * @method static static VISA()
 * @method static static MASTER_CARD()
 */
final class PaymentType extends Enum
{
    const DAHABIA = 'dahabia';
    const VISA = 'visa';
    const MASTER_CARD = 'master_card';
}
