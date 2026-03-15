<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable = ['name_ar', 'name_en', 'icon', 'order', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
