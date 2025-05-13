<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // تحقق من صحة البيانات
        $credentials = $request->only('email', 'password');

        if (!Auth::guard('web')->attempt($credentials)) {
            return response()->json([
                'message' => 'بيانات الدخول غير صحيحة'
            ], 401);
        }

        // جلب المستخدم من جارد "web"
        $user = Auth::guard('web')->user();
        // الحصول على المستخدم المصادق عليه
        //$user = Auth::user();

        // تأكد إنه فعلاً من نوع App\Models\User
        if (!($user instanceof \App\Models\User)) {
            return response()->json([
                'message' => 'المستخدم غير صالح أو نوع غير مدعوم'
            ], 500);
        }

        //dd(get_class($user));
        // إنشاء التوكن باستخدام Sanctum
        $token = $user->createToken('api-token')->plainTextToken;

        // إرجاع التوكن والمستخدم
        return response()->json([
            'token' => $token,
            'user' => $user
        ]);
    }

    public function me(Request $request)
    {
        return response()->json([
            'user' => $request->user(),
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'تم تسجيل الخروج بنجاح'
        ]);
    }

}

