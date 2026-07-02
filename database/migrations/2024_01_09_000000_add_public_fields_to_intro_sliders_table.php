<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('intro_sliders', function (Blueprint $table) {
            $table->string('slug')->unique()->nullable()->after('title');
            $table->string('meta_title')->nullable()->after('slug');
            $table->string('meta_description')->nullable()->after('meta_title');
            $table->text('short_content')->nullable()->after('description');
            $table->string('cta_text')->nullable()->after('product_slug');
            $table->string('cta_url')->nullable()->after('cta_text');
            $table->string('badge_text')->nullable()->after('cta_url');
            $table->string('badge_type')->nullable()->after('badge_text');
            $table->string('video_url')->nullable()->after('badge_type');
            $table->string('background_color')->nullable()->after('video_url');
            $table->string('text_color')->nullable()->after('background_color');
            $table->string('alignment')->default('left')->after('text_color');
            $table->string('overlay_opacity')->nullable()->after('alignment');
        });
    }

    public function down(): void
    {
        Schema::table('intro_sliders', function (Blueprint $table) {
            $table->dropColumn([
                'slug',
                'meta_title',
                'meta_description',
                'short_content',
                'cta_text',
                'cta_url',
                'badge_text',
                'badge_type',
                'video_url',
                'background_color',
                'text_color',
                'alignment',
                'overlay_opacity',
            ]);
        });
    }
};
