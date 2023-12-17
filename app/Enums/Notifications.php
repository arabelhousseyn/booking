<?php

namespace App\Enums;

use App\Events\BookingTerminated;
use App\Notifications\NewHouse;
use App\Notifications\NewVehicle;
use App\Notifications\SellerDispute;
use App\Notifications\SignupSeller;
use App\Notifications\SignupUser;
use App\Notifications\UserDispute;
use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;
use App\Notifications\BookingDeclined;

/**
 * @method static static BOOKING_DECLINED()
 * @method static static BOOKING_TERMINATED()
 * @method static static NEW_HOUSE()
 * @method static static NEW_VEHICLE()
 * @method static static SELLER_DISPUTE()
 * @method static static USER_DISPUTE()
 * @method static static SIGNUP_SELLER()
 * @method static static SIGNUP_USER()
 */
class Notifications extends Enum implements LocalizedEnum
{
    const BOOKING_DECLINED = BookingDeclined::class;
    const BOOKING_TERMINATED = BookingTerminated::class;
    const NEW_HOUSE = NewHouse::class;
    const NEW_VEHICLE = NewVehicle::class;
    const SELLER_DISPUTE = SellerDispute::class;
    const USER_DISPUTE = UserDispute::class;
    const SIGNUP_SELLER = SignupSeller::class;
    const SIGNUP_USER = SignupUser::class;
}
