<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('restrictions', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->enum('niveau', ['vigilance', 'alerte', 'crise'])->default('vigilance');
            $table->text('description');
            $table->timestamp('date_debut');
            $table->timestamp('date_fin')->nullable();
            $table->foreignId('zone_id')->constrained('zones')->cascadeOnDelete();
            $table->foreignId('cree_par')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
            
            $table->index('zone_id');
            $table->index('niveau');
            $table->index('date_debut');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('restrictions');
    }
};
