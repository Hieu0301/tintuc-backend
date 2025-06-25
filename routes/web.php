<?php

use Illuminate\Support\Facades\Route;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Response;

Route::get('/check-cloudinary', function () {
    return config('cloudinary.cloud_url'); // phải trả về đúng URL
});


Route::get('/test-cloud', function () {
    try {
        $url = Cloudinary::upload(public_path('GAM.PNG'))->getSecurePath();
        return $url;
    } catch (\Exception $e) {
        return $e->getMessage();
    }
});

Route::get('/storage/images/{filename}', function ($filename) {
    $path = storage_path('app/public/images/' . $filename);

    if (!file_exists($path)) {
        abort(404);
    }

    return Response::file($path);
});
