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
        Schema::create('core', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('commission');

            $table->uuid('commission_updated_by')->nullable();
            $table->foreign('commission_updated_by')
                ->on('admins')
                ->references('id');

            $table->string('KM')->default(50);

            $table->string('vehicle_dahabia_caution')->default(40000);
            $table->string('vehicle_debit_card_caution')->default(100);

            $table->string('house_dahabia_caution')->default(40000);
            $table->string('house_debit_card_caution')->default(100);

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
        Schema::dropIfExists('cores');
    }
};
