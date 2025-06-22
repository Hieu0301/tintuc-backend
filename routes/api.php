<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;


Route::apiResource('categories', CategoryController::class);
Route::apiResource('articles', ArticleController::class);

Route::get('/categories/{id}/articles', [CategoryController::class, 'articles']);
Route::post('/upload-image', [UploadController::class, 'uploadImage']);
Route::get('/test-mail', function () {
    Mail::raw('Đây là email test', function ($message) {
        $message->to('diachi@example.com')
            ->subject('Test gửi mail từ Laravel');
    });

    return 'Đã gửi!';
});


Route::post('/subscribe', [NewsletterController::class, 'subscribe']);
