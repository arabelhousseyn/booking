<?php

namespace App\Policies;

use App\Enums\Status;
use App\Models\Seller;
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

    public function create(User|Seller $user, Vehicle $vehicle): bool
    {
        return $vehicle->status->is(Status::PUBLISHED);
    }

    public function update(User|Seller $user, Vehicle $vehicle): bool
    {
        return $vehicle->status->is(Status::PENDING) || $vehicle->status->is(Status::PUBLISHED);
    }
}
