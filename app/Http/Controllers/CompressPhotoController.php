<?php

namespace App\Http\Controllers;
use Spatie\LaravelImageOptimizer\Facades\ImageOptimizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompressPhotoController extends Controller
{
    public function showForm()
    {
        return view('upload');
    }

    public function uploadAndOptimize(Request $request)
    {
        // التحقق من وجود الصورة وصحة الصيغة
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,gif,svg|max:10240', // 5MB كحد أقصى
        ]);

        // حفظ الصورة داخل مجلد التخزين
        $path = $request->file('image')->store('uploads', 'public');
        // المسار الكامل للصورة داخل السيرفر
        $fullPath = storage_path('app/public/' . $path);

        // الحجم قبل الضغط
        $sizeBefore = filesize($fullPath);

        // ضغط الصورة باستخدام مكتبة Spatie
        ImageOptimizer::optimize($fullPath);

        // الحجم بعد الضغط
        $sizeAfter = filesize($fullPath);

        // تمرير البيانات إلى الواجهة
        return view('upload')->with([
            'imagePath' => Storage::url($path),
            'sizeBefore' => $sizeBefore,
            'sizeAfter' => $sizeAfter
        ]);
    }

}
