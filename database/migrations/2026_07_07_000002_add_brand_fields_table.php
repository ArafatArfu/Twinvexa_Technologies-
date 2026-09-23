<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->string('banner_image')->nullable()->after('logo');
            $table->text('short_description')->nullable()->after('banner_image');
            $table->text('description')->nullable()->after('short_description');
            $table->string('website_url')->nullable()->after('description');
            $table->boolean('is_featured')->default(false)->after('is_active');
            $table->integer('display_order')->default(0)->after('is_featured');
        });
    }

    public function down(): void
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->dropColumn(['banner_image', 'short_description', 'description', 'website_url', 'is_featured', 'display_order']);
        });
    }
};
