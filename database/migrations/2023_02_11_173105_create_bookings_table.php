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
        Schema::create('bookings', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('user_id');
            $table->foreign('user_id')
                ->on('users')
                ->references('id')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->uuid('seller_id');
            $table->foreign('seller_id')
                ->on('sellers')
                ->references('id')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->uuidMorphs('bookable');
            $table->string('payment_type');
            $table->float('net_price');
            $table->float('total_price');
            $table->integer('commission');
            $table->boolean('has_caution')->default(false);
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->string('status');
            $table->string('coupon_code')->nullable();

            $table->unique(['user_id', 'seller_id', 'bookable_type', 'bookable_id']);
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
        Schema::dropIfExists('bookings');
    }
};
