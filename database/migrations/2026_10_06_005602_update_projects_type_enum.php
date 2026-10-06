<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, change enum to string to allow any value
        Schema::table('projects', function (Blueprint $table) {
            $table->string('type', 50)->change();
        });
        
        // Update existing data to use new enum values
        DB::statement("UPDATE projects SET type = 'modernisation' WHERE type = 'rénovation'");
        DB::statement("UPDATE projects SET type = 'construction' WHERE type = 'décontamination'");
        
        // Then change back to enum with new values
        Schema::table('projects', function (Blueprint $table) {
            $table->enum('type', ['réparation', 'modernisation', 'extension', 'construction'])->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // First, change enum to string
        Schema::table('projects', function (Blueprint $table) {
            $table->string('type', 50)->change();
        });
        
        // Revert data to old enum values
        DB::statement("UPDATE projects SET type = 'rénovation' WHERE type = 'modernisation'");
        DB::statement("UPDATE projects SET type = 'décontamination' WHERE type = 'construction'");
        
        // Change back to old enum
        Schema::table('projects', function (Blueprint $table) {
            $table->enum('type', ['rénovation', 'décontamination', 'extension', 'modernisation'])->change();
        });
    }
};
