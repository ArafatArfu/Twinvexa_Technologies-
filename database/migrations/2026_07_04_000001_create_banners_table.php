<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->text('highlight_text')->nullable();
            $table->string('button_text')->nullable()->default('Shop Now');
            $table->string('button_link')->nullable();
            $table->string('image')->nullable();
            $table->string('background_color')->nullable()->default('#ffffff');
            $table->string('text_color')->nullable()->default('#333333');
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
