<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable = ['name_ar', 'name_en', 'image', 'order', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // دالة مساعدة للحصول على مسار الصورة
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }
}
