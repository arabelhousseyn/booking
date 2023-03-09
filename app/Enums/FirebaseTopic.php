<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * @method static static USERS()
 * @method static static SELLERS()
 */
class FirebaseTopic extends Enum implements LocalizedEnum
{
    const USERS = '/topics/users';
    const SELLERS = '/topics/sellers';
}
