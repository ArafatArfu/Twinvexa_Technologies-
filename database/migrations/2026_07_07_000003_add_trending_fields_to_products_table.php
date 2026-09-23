<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('is_trending')->default(false)->after('is_deal');
            $table->boolean('is_top_rated')->default(false)->after('is_trending');
            $table->boolean('is_best_selling')->default(false)->after('is_top_rated');
            $table->boolean('is_on_sale')->default(false)->after('is_best_selling');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['is_trending', 'is_top_rated', 'is_best_selling', 'is_on_sale']);
        });
    }
};
