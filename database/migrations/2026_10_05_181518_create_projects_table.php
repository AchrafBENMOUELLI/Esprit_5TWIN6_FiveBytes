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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('titre', 200);
            $table->enum('type', ['rénovation', 'décontamination', 'extension', 'modernisation']);
            $table->text('description');
            $table->decimal('budget_prevu', 15, 2);
            $table->date('date_debut');
            $table->date('date_fin_prevue');
            $table->enum('statut', ['planifié', 'en_cours', 'suspendu', 'terminé', 'annulé']);
            $table->integer('avancement_pourcentage')->default(0);
            $table->foreignId('zone_id')->constrained('zones')->onDelete('cascade');
            $table->foreignId('infrastructure_id')->nullable()->constrained('infrastructures')->onDelete('set null');
            $table->foreignId('responsable_id')->constrained('users')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
