<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('footer_settings', function (Blueprint $table) {
            $table->id();
            $table->string('background_image')->nullable();
            $table->string('newsletter_title')->nullable();
            $table->string('newsletter_subtitle')->nullable();
            $table->string('email_placeholder')->nullable();
            $table->string('button_text')->nullable();
            $table->boolean('is_newsletter_active')->default(true);
            $table->string('footer_logo')->nullable();
            $table->string('footer_description')->nullable();
            $table->string('phone_support_text')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('support_icon')->nullable();
            $table->text('copyright_text')->nullable();
            $table->json('social_links')->nullable();
            $table->string('payment_image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('footer_settings');
    }
};
