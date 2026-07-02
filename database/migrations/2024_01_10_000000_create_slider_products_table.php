<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('slider_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('intro_slider_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('brand_id')->nullable()->constrained()->nullOnDelete();
            $table->string('sku')->nullable();
            $table->string('price');
            $table->string('old_price')->nullable();
            $table->integer('quantity')->default(0);
            $table->text('short_description')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('slider_products');
    }
};
