<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')
                  ->constrained('owners')
                  ->cascadeOnDelete();

            $table->foreignId('brand_id')
                  ->constrained('brands');

            $table->string('color', 50)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
