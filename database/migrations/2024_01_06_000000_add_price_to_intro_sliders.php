<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('intro_sliders', function (Blueprint $table) {
            $table->string('price')->nullable()->after('button_url');
            $table->string('old_price')->nullable()->after('price');
            $table->string('product_slug')->nullable()->after('old_price');
        });
    }

    public function down(): void
    {
        Schema::table('intro_sliders', function (Blueprint $table) {
            $table->dropColumn(['price', 'old_price', 'product_slug']);
        });
    }
};