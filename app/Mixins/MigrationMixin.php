<?php

namespace App\Mixins;

use Illuminate\Database\Schema\Blueprint;

class MigrationMixin
{
    public Blueprint $table;

    public function firebaseToken(): \Closure
    {
        return function () {
            return static::string('firebase_registration_token')->nullable();
        };
    }
}
