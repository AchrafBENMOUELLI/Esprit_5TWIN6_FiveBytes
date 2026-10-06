<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scheduled_cuts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restriction_id')->constrained('restrictions')->cascadeOnDelete();
            $table->foreignId('zone_id')->constrained('zones')->cascadeOnDelete();
            $table->dateTime('debut');
            $table->dateTime('fin');
            $table->text('motif')->nullable();
            $table->timestamps();
            
            $table->index('restriction_id');
            $table->index('zone_id');
            $table->index('debut');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scheduled_cuts');
    }
};
