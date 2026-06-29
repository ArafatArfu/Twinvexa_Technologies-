<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('navbar_items', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('url')->nullable();
            $table->string('icon')->nullable();
            $table->string('label')->nullable();
            $table->string('label_class')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_visible')->default(true);
            $table->boolean('is_dropdown')->default(false);
            $table->string('target')->default('_self');
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('navbar_items')->onDelete('cascade');
        });

        Schema::create('navbar_settings', function (Blueprint $table) {
            $table->id();
            $table->string('logo')->nullable();
            $table->string('sticky_class')->nullable();
            $table->json('custom_class')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('navbar_items');
        Schema::dropIfExists('navbar_settings');
    }
};