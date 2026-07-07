<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('trending_banners', function (Blueprint $table) {
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete()->after('button_link');
        });
    }

    public function down(): void
    {
        Schema::table('trending_banners', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropColumn('product_id');
        });
    }
};
