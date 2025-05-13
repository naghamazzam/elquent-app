<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\LocationLog;
use Illuminate\Support\Facades\Auth;

class LocationController extends Controller
{
    // استلام الإحداثيات من التطبيق
    public function updateLocation(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $user = Auth::user(); // المستخدم الحالي (الساعي)

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // 🔄 تحديث أو إنشاء آخر موقع
        Location::updateOrCreate(
            ['user_id' => $user->id],
            ['latitude' => $request->latitude, 'longitude' => $request->longitude]
        );

        // 📝 إضافة إلى سجل الحركة
        LocationLog::create([
            'user_id' => $user->id,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return response()->json(['message' => 'Location updated'], 200);
    }
}
