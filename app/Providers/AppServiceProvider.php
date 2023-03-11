<?php

namespace App\Providers;

use App\Enums\ModelType;
use App\Mixins\MigrationMixin;
use App\Models\House;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
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

        $this->mixins();

        Model::preventLazyLoading(!app()->isProduction());

        Relation::morphMap([
            ModelType::HOUSE => House::class,
            ModelType::VEHICLE => Vehicle::class,
        ]);

        Validator::extend('poly_exists', function ($attribute, $value, $parameters, $validator) {
            if (!$type = Arr::get($validator->getData(), $parameters[0], false)) {
                return false;
            }

            if (Relation::getMorphedModel($type)) {
                $type = Relation::getMorphedModel($type);
            }

            if (!class_exists($type)) {
                return false;
            }

            return !empty(resolve($type)->find($value));
        });
    }

    private function mixins(): void
    {
        Blueprint::mixin(new MigrationMixin());
    }
}
