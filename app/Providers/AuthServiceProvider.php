<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Booking;
use App\Models\House;
use App\Models\Vehicle;
use App\Policies\BookingPolicy;
use App\Policies\HousePolicy;
use App\Policies\VehiclePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Booking::class => BookingPolicy::class,
        House::class => HousePolicy::class,
        Vehicle::class => VehiclePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
