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
        Schema::create('incidents', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique()->comment('Format INC-2026-0001');
            $table->string('type');
            $table->text('description');
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->enum('urgence', ['faible', 'moyenne', 'haute', 'critique']);
            $table->enum('statut', ['nouveau', 'assigne', 'en_cours', 'resolu', 'rejete', 'doublon', 'ferme'])->default('nouveau');
            
            // Foreign keys
            $table->foreignId('citoyen_id')
                  ->constrained('users')
                  ->onDelete('cascade')
                  ->comment('Utilisateur qui a signalé l\'incident');
            
            $table->foreignId('technicien_id')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null')
                  ->comment('Technicien affecté à l\'incident');
            
            $table->foreignId('infrastructure_id')
                  ->nullable()
                  ->constrained('infrastructures')
                  ->onDelete('set null')
                  ->comment('Infrastructure concernée par l\'incident');
            
            $table->foreignId('incident_parent_id')
                  ->nullable()
                  ->constrained('incidents')
                  ->onDelete('cascade')
                  ->comment('Incident parent si doublon détecté');
            
            $table->timestamp('date_resolution')->nullable()->comment('Date de résolution de l\'incident');
            $table->timestamps();
            
            // Index pour les performances
            $table->index(['statut', 'urgence']);
            $table->index('citoyen_id');
            $table->index('infrastructure_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incidents');
    }
};
