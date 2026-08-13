<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('testimonials', function (Blueprint $table) {
            $table->string('type')->default('testimonial')->after('id');
            $table->string('emoji', 10)->nullable()->after('type');
            $table->boolean('is_active')->default(true)->after('is_approved');
        });
    }

    public function down(): void
    {
        Schema::table('testimonials', function (Blueprint $table) {
            $table->dropColumn(['type', 'emoji']);
        });
    }
};
