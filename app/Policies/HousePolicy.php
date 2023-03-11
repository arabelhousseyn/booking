<?php

namespace App\Policies;

use App\Enums\Status;
use App\Models\House;
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

    public function create(User $user, House $bookable): bool
    {
        return $bookable->status->is(Status::PUBLISHED);
    }
}
