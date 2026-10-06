<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('zone_id')->constrained('zones')->cascadeOnDelete();
            $table->enum('canal', ['email', 'sms', 'app'])->default('email');
            $table->boolean('actif')->default(true);
            $table->timestamps();
            
            $table->unique(['user_id', 'zone_id', 'canal']);
            $table->index('user_id');
            $table->index('zone_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
