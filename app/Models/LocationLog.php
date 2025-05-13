<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LocationLog extends Model
{
    public $timestamps = false; // لأننا مش بحاجة لـ `updated_at` و`created_at` في هذا الجدول
    protected $fillable = ['user_id', 'latitude', 'longitude'];

    // تعريف العلاقة مع جدول المستخدمين
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
