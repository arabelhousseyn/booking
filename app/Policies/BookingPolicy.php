<?php

namespace App\Policies;

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
}
