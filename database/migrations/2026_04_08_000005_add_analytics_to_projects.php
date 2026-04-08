<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add analytics columns to projects table
        Schema::table('projects', function (Blueprint $table) {
            $table->unsignedBigInteger('views_count')->default(0)->after('is_featured');
            $table->unsignedBigInteger('likes_count')->default(0)->after('views_count');
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['views_count', 'likes_count']);
        });
    }
};
