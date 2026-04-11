<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('experiences', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // work, education, certification
            $table->string('title');
            $table->string('company')->nullable();
            $table->string('location')->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable(); // null = current
            $table->boolean('is_current')->default(false);
            $table->text('description')->nullable();
            $table->json('highlights')->nullable(); // Key achievements
            $table->string('logo_url')->nullable();
            $table->string('link')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['type', 'is_current', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('experiences');
    }
};
