<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Artisan;

// Route::apiResource('categories', CategoryController::class);
// Route::apiResource('articles', ArticleController::class);

// Route::get('/categories/{id}/articles', [CategoryController::class, 'articles']);
// Route::post('/upload-image', [UploadController::class, 'uploadImage']);
// Route::get('/test-mail', function () {
//     Mail::raw('Đây là email test', function ($message) {
//         $message->to('diachi@example.com')
//             ->subject('Test gửi mail từ Laravel');
//     });

//     return 'Đã gửi!';
// });


// Route::post('/subscribe', [NewsletterController::class, 'subscribe']);

// Route::get('/test', function () {
//     return response('Laravel is OK', 200);
// });

// Route::get('/run-key', function () {
//     Artisan::call('key:generate');
//     return response()->json(['message' => 'APP_KEY generated!']);
// });

// Route::get('/run-migrate', function () {
//     Artisan::call('migrate', ['--force' => true]);
//     return response()->json(['message' => 'Migration done!']);
// });


Route::get('/ping', function () {
    return response()->json(['message' => 'pong']);
});
