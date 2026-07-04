<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->text('shipping_information')->nullable()->after('description');
            $table->text('return_policy')->nullable()->after('shipping_information');
            $table->integer('display_order')->default(0)->after('order');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['shipping_information', 'return_policy', 'display_order']);
        });
    }
};
