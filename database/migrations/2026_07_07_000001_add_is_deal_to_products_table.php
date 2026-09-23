<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('is_deal')->default(false)->after('is_new_arrival');
            $table->string('deal_label')->nullable()->after('is_deal');
            $table->date('deal_start_date')->nullable()->after('deal_label');
            $table->date('deal_end_date')->nullable()->after('deal_start_date');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['is_deal', 'deal_label', 'deal_start_date', 'deal_end_date']);
        });
    }
};
