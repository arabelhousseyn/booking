<?php

namespace App\Policies;

use App\Enums\Status;
use App\Models\House;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class HousePolicy
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

    public function create(User|Seller $user, House $house): bool
    {
        return $house->status->is(Status::PUBLISHED);
    }

    public function update(User|Seller $user, House $house): bool
    {
        return $house->status->is([Status::PENDING, Status::PUBLISHED]);
    }
}
