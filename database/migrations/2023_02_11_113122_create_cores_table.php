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
            $table->uuid('commission_updated_by');

            $table->foreign('commission_updated_by')
                ->on('admins')
                ->references('id');

            $table->string('KM')->default(50);

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
