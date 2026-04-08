<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('text'); // text, boolean, json, file
            $table->timestamps();
        });
        
        // Add maintenance mode to profile_settings if not exists
        // We'll handle this in the seeder
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
