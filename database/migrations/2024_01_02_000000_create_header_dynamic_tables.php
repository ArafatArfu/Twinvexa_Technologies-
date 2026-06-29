<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('header_sections', function (Blueprint $table) {
            $table->id();
            $table->string('type')->default('top_bar');
            $table->string('key')->unique();
            $table->string('title')->nullable();
            $table->string('content')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
        });

        Schema::create('header_menus', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('url')->nullable();
            $table->string('icon')->nullable();
            $table->string('label')->nullable();
            $table->string('label_class')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('section_id');
            $table->integer('order')->default(0);
            $table->boolean('is_visible')->default(true);
            $table->boolean('is_megamenu')->default(false);
            $table->string('megamenu_class')->nullable();
            $table->string('target')->default('_self');
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('header_menus')->onDelete('cascade');
            $table->foreign('section_id')->references('id')->on('header_sections')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('header_menus');
        Schema::dropIfExists('header_sections');
    }
};