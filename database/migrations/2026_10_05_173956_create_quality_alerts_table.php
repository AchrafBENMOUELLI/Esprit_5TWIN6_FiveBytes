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
        Schema::create('quality_alerts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('water_sample_id')->constrained()->cascadeOnDelete();
            $table->string('niveau');
            $table->text('message');
            $table->boolean('publiee')->default(false);
            $table->dateTime('date_resolution')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quality_alerts');
    }
};
