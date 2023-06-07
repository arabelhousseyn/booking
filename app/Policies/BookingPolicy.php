<?php

namespace App\Policies;

use App\Enums\BookingStatus;
use App\Models\Booking;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BookingPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function view(User|Seller $model, Booking $booking): bool
    {
        return $model->is(($model instanceof User) ? $booking->user : $booking->seller);
    }

    public function decline(User $user, Booking $booking): bool
    {
        return $booking->status->isNot([BookingStatus::COMPLETED, BookingStatus::DECLINED]);
    }

    public function satim(User $user, Booking $booking, string $order_id): bool
    {
        return $booking->satim_order_id === $order_id;
    }
}
