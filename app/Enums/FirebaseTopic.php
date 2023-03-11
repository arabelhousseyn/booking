<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * @method static static USERS()
 * @method static static SELLERS()
 * @method static static ALL()
 */
class FirebaseTopic extends Enum implements LocalizedEnum
{
    const USERS = '/topics/users';
    const SELLERS = '/topics/sellers';
    const ALL = '/topics/all';
}
