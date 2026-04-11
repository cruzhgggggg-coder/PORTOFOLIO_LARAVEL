<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // Add new columns if they don't exist
            if (! Schema::hasColumn('projects', 'slug')) {
                $table->string('slug')->unique()->after('title');
            }
            if (! Schema::hasColumn('projects', 'tech_stack')) {
                $table->json('tech_stack')->nullable()->after('description');
            }
            if (! Schema::hasColumn('projects', 'link_repo')) {
                $table->string('link_repo')->nullable()->after('image');
            }
            if (! Schema::hasColumn('projects', 'link_demo')) {
                $table->string('link_demo')->nullable()->after('link_repo');
            }
            // Rename 'image' to 'image_url' if exists
            if (Schema::hasColumn('projects', 'image') && ! Schema::hasColumn('projects', 'image_url')) {
                $table->renameColumn('image', 'image_url');
            }
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['slug', 'tech_stack', 'link_repo', 'link_demo']);
            if (Schema::hasColumn('projects', 'image_url')) {
                $table->renameColumn('image_url', 'image');
            }
        });
    }
};
