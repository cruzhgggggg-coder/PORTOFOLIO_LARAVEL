<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('title')->nullable(); // Job title
            $table->string('company')->nullable();
            $table->string('email')->nullable();
            $table->string('avatar_url')->nullable();
            $table->text('content');
            $table->unsignedTinyInteger('rating')->default(5); // 1-5 stars
            $table->string('project_name')->nullable(); // Related project
            $table->string('project_url')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_approved')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index(['is_featured', 'is_approved', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
