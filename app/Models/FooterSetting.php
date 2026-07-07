<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FooterSetting extends Model
{
    protected $fillable = [
        'background_image',
        'newsletter_title',
        'newsletter_subtitle',
        'email_placeholder',
        'button_text',
        'is_newsletter_active',
        'footer_logo',
        'footer_description',
        'phone_support_text',
        'phone_number',
        'support_icon',
        'copyright_text',
        'social_links',
        'payment_image',
        'is_active',
    ];

    protected $casts = [
        'is_newsletter_active' => 'boolean',
        'is_active' => 'boolean',
        'social_links' => 'array',
    ];
}
