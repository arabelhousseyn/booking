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

    public function ribBankAccount(): \Closure
    {
        return function () {
            return static::string('rib_bank_account')->nullable();
        };
    }

    public function dahabiaAccount(): \Closure
    {
        return function () {
            return static::string('dahabia_account')->nullable();
        };
    }
}
