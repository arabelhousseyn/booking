<?php

namespace App\Providers;

use App\Enums\ModelType;
use App\Models\House;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        Model::preventLazyLoading(!app()->isProduction());

        Relation::morphMap([
            ModelType::HOUSE => House::class,
            ModelType::VEHICLE => Vehicle::class,
        ]);
    }
}
