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
        Schema::create('vehicle_documents', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('vehicle_id');
            $table->foreign('vehicle_id')
                ->on('vehicles')
                ->references('id')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->string('document_type');
            $table->string('document_url');
            $table->date('expiry_date');

            $table->unique(['vehicle_id', 'document_type']);
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
        Schema::dropIfExists('vehicle_documents');
    }
};
