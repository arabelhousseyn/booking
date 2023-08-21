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
        Schema::create('houses', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('seller_id');
            $table->foreign('seller_id')
                ->on('sellers')
                ->references('id')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->string('title');
            $table->text('description');
            $table->string('coordinates');
            $table->float('price', 8, 2);
            $table->integer('rooms');
            $table->boolean('has_wifi');
            $table->boolean('parking_station');
            $table->date('availability_start_date');
            $table->date('availability_end_date');
            $table->string('status');

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
        Schema::dropIfExists('houses');
    }
};
