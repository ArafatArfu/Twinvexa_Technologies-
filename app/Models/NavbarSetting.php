<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NavbarSetting extends Model
{
    protected $fillable = [
        'logo',
        'sticky_class',
        'custom_class',
    ];

    protected $casts = [
        'custom_class' => 'array',
    ];
}