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
 * @method static static CAN_MANAGE_HOUSES()
 * @method static static CAN_MANAGE_VEHICLES()
 * @method static static CAN_MANAGE_BOOKINGS()
 * @method static static CAN_MANAGE_PROMO_CODES()
 * @method static static CAN_MANAGE_REVIEWS()
 * @method static static CAN_MANAGE_ADS()
 * @method static static CAN_MANAGE_SETTINGS()
 * @method static static CAN_MANAGE_SETTINGS__GENERAL()
 * @method static static CAN_MANAGE_SETTINGS__RECLAMATIONS()
 * @method static static CAN_MANAGE_SETTINGS__ROLES()
 * @method static static CAN_MANAGE_SETTINGS__NOTIFICATIONS()
 */
final class Permissions extends Enum implements LocalizedEnum
{
    const CAN_MANAGE_DASHBOARD = 'can_manage_dashboard';

    const CAN_MANAGE_ACCOUNTS = 'can_manage_accounts';
    const CAN_MANAGE_ACCOUNTS__ADMINS = 'can_manage_accounts__admins';
    const CAN_MANAGE_ACCOUNTS__USERS = 'can_manage_accounts__users';
    const CAN_MANAGE_ACCOUNTS__PARTNERS = 'can_manage_accounts__partners';

    const CAN_MANAGE_HOUSES = 'can_manage_houses';

    const CAN_MANAGE_VEHICLES = 'can_manage_vehicles';

    const CAN_MANAGE_BOOKINGS = 'can_manage_bookings';

    const CAN_MANAGE_PROMO_CODES = 'can_manage_promo_codes';

    const CAN_MANAGE_REVIEWS = 'can_manage_reviews';

    const CAN_MANAGE_ADS = 'can_manage_ads';

    const CAN_MANAGE_SETTINGS = 'can_manage_settings';
    const CAN_MANAGE_SETTINGS__GENERAL = 'can_manage_settings__general';
    const CAN_MANAGE_SETTINGS__RECLAMATIONS = 'can_manage_settings__reclamations';
    const CAN_MANAGE_SETTINGS__ROLES = 'can_manage_settings__roles';
    const CAN_MANAGE_SETTINGS__NOTIFICATIONS = 'can_manage_settings__notifications';
}
