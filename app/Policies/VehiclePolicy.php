<?php

namespace App\Policies;

use App\Enums\Status;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Auth\Access\HandlesAuthorization;

class VehiclePolicy
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

    public function create(User $user, Vehicle $bookable): bool
    {
        return $bookable->status->is(Status::PUBLISHED);
    }
}
