<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('water_levels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('zone_id')->constrained('zones')->cascadeOnDelete();
            $table->string('source'); // reservoir, nappe, barrage
            $table->decimal('niveau_pourcentage', 5, 2); // 0-100%
            $table->decimal('volume_m3', 15, 2);
            $table->timestamp('date_releve');
            $table->timestamps();
            
            $table->index('zone_id');
            $table->index('date_releve');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('water_levels');
    }
};
