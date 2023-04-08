<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * @method static static CAN_MANAGE_DASHBOARD()
 * @method static static CAN_MANAGE_ACCOUNTS()
 * @method static static CAN_MANAGE_ACCOUNTS__ADMINS()
 * @method static static CAN_MANAGE_ACCOUNTS__USERS()
 * @method static static CAN_MANAGE_ACCOUNTS__PARTNERS()
 */
final class Permissions extends Enum implements LocalizedEnum
{
    // todo : implement the rest of permissions

    const CAN_MANAGE_DASHBOARD = 'can_manage_dashboard';

    const CAN_MANAGE_ACCOUNTS = 'can_manage_accounts';
    const CAN_MANAGE_ACCOUNTS__ADMINS = 'can_manage_accounts__admins';
    const CAN_MANAGE_ACCOUNTS__USERS = 'can_manage_accounts__users';
    const CAN_MANAGE_ACCOUNTS__PARTNERS = 'can_manage_accounts__partners';


}
