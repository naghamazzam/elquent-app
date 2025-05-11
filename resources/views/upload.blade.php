<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>upload image with compretion</title>
    <style>
        body { font-family: Arial; direction: rtl; padding: 30px; background: #f7f7f7; }
        .container { background: white; padding: 20px; border-radius: 10px; max-width: 500px; margin: auto; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        label, button { display: block; margin-top: 15px; }
        img { margin-top: 15px; max-width: 100%; }
    </style>
</head>

<body>
    <div class="container">
        <h2>upload image and compress it</h2>

        @if($errors->any())
            <div style="color: red;">{{ $errors->first() }}</div>
        @endif

        <form action="{{ url('/upload-image') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <label for="image">choose image :</label>
            <input type="file" name="image" required>
            <button type="submit">upload image</button>
        </form>

        @isset($imagePath)
            <h4>image is uploaded:</h4>
            <img src="{{ $imagePath }}" alt="الصورة المضغوطة">
            <p><a href="{{ $imagePath }}" target="_blank">open the image</a></p>

            @if(isset($sizeBefore) && isset($sizeAfter))
                <p>الحجم قبل الضغط: {{ number_format($sizeBefore / 1024, 2) }} KB</p>
                <p>الحجم بعد الضغط: {{ number_format($sizeAfter / 1024, 2) }} KB</p>
            @endif
        @endisset
    </div>
</body>
</html>
