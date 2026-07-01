<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NavbarSetting extends Model
{
    protected $fillable = [
        'logo',
        'logo_width',
        'logo_height',
        'logo_text',
        'sticky_class',
        'contact_number',
        'contact_icon',
        'top_bar_text',
        'top_bar_highlight',
        'custom_class',
    ];

    protected $casts = [
        'custom_class' => 'array',
    ];
}