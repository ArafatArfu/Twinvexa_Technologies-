<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->unsignedInteger('parent_id')->nullable()->after('id');
            $table->text('short_description')->nullable()->after('name');
            $table->text('description')->nullable()->after('short_description');
            $table->string('banner')->nullable()->after('image');
            $table->string('icon')->nullable()->after('banner');
            $table->boolean('is_featured')->default(false)->after('is_active');
            $table->string('meta_title')->nullable()->after('order');
            $table->string('meta_description')->nullable()->after('meta_title');
            
            $table->foreign('parent_id')->references('id')->on('categories')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropColumn([
                'parent_id',
                'short_description',
                'description',
                'banner',
                'icon',
                'is_featured',
                'meta_title',
                'meta_description',
            ]);
        });
    }
};
