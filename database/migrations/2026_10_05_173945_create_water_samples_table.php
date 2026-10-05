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
        Schema::create('water_samples', function (Blueprint $table) {
            $table->id();
            $table->foreignId('zone_id')->constrained()->cascadeOnDelete();
            $table->foreignId('infrastructure_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('preleve_par')->constrained('users');
            $table->dateTime('date_prelevement');
            $table->string('resultat_global')->nullable();
            $table->text('resume_ia')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('water_samples');
    }
};
