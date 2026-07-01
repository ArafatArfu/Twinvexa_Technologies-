<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('navbar_settings', function (Blueprint $table) {
            $table->string('contact_number')->nullable()->after('sticky_class');
            $table->string('contact_icon')->nullable()->after('contact_number');
            $table->string('logo_text')->nullable()->after('logo');
            $table->string('top_bar_text')->nullable()->after('contact_icon');
            $table->string('top_bar_highlight')->nullable()->after('top_bar_text');
        });
    }

    public function down(): void
    {
        Schema::table('navbar_settings', function (Blueprint $table) {
            $table->dropColumn(['contact_number', 'contact_icon', 'logo_text', 'top_bar_text', 'top_bar_highlight']);
        });
    }
};