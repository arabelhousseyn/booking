<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone')->unique();
            $table->string('phone_verified_at')->nullable();
            $table->string('country_code');
            $table->string('otp')->nullable();
            $table->boolean('can_rent_house')->default(true);
            $table->boolean('can_rent_vehicle')->default(false);
            $table->string('coordinates')->nullable();
            $table->timestamp('validated_at')->nullable();

            $table->uuid('validated_by')->nullable();
            $table->foreign('validated_by')
                ->on('admins')
                ->references('id');

            $table->firebaseToken();

            $table->string('password');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
