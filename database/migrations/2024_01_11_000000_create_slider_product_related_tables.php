<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('slider_product_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('slider_product_id')->constrained()->cascadeOnDelete();
            $table->string('image');
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::create('slider_product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('slider_product_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('sku')->nullable();
            $table->string('price')->nullable();
            $table->string('old_price')->nullable();
            $table->integer('quantity')->default(0);
            $table->string('attribute_name')->nullable();
            $table->string('attribute_value')->nullable();
            $table->timestamps();
        });

        Schema::create('slider_product_specifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('slider_product_id')->constrained()->cascadeOnDelete();
            $table->string('key');
            $table->text('value')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::create('slider_product_tags', function (Blueprint $table) {
            $table->id();
            $table->foreignId('slider_product_id')->constrained()->cascadeOnDelete();
            $table->string('tag');
            $table->timestamps();
        });

        Schema::create('slider_product_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('slider_product_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('email')->nullable();
            $table->integer('rating')->default(5);
            $table->text('comment')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('slider_product_reviews');
        Schema::dropIfExists('slider_product_tags');
        Schema::dropIfExists('slider_product_specifications');
        Schema::dropIfExists('slider_product_variants');
        Schema::dropIfExists('slider_product_images');
    }
};
