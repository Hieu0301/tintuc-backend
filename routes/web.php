<?php

use Illuminate\Support\Facades\Route;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

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
