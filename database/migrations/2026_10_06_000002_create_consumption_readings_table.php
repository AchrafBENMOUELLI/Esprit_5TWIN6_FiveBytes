<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consumption_readings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('zone_id')->constrained('zones')->cascadeOnDelete();
            $table->decimal('volume_m3', 15, 2);
            $table->timestamp('periode_debut');
            $table->timestamp('periode_fin');
            $table->text('prevision_ia')->nullable();
            $table->timestamps();
            
            $table->index('zone_id');
            $table->index('periode_debut');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consumption_readings');
    }
};
