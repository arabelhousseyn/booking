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
    public function up(): void
    {
        Schema::create('coupon_usages', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('user_id')->nullable();
            $table->foreign('user_id')
                ->on('users')
                ->references('id');

            $table->uuid('coupon_id')->nullable();
            $table->foreign('coupon_id')
                ->on('coupons')
                ->references('id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('coupon_usages');
    }
};
