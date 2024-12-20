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

            $table->string('reference');

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

            $table->string('satim_order_id')->nullable();
            $table->string('payment_intent_id')->nullable();

            $table->uuidMorphs('bookable');
            $table->string('payment_type');
            $table->float('original_price', 8, 2);
            $table->float('calculated_price', 8, 2);
            $table->integer('commission');
            $table->float('caution', 8, 2);
            $table->float('refund', 8, 2)->nullable();
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->string('coupon_code')->nullable();
            $table->text('note')->nullable();
            $table->string('status');
            $table->string('payment_status');

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
