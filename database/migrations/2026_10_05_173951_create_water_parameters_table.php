<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('water_parameters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('water_sample_id')->constrained()->cascadeOnDelete();
            $table->foreignId('threshold_id')->constrained()->restrictOnDelete();
            $table->decimal('valeur', 10, 3);
            $table->boolean('depasse_seuil')->default(false);
            $table->timestamps();

            $table->unique(['water_sample_id', 'threshold_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('water_parameters');
    }
};
