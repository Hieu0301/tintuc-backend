<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\ArticaleRequest;
use App\Mail\NewArticleNotification;
use App\Models\Article;
use App\Models\NewsletterSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $article = Article::latest()->paginate(6);

        return response()->json([
            'success' => true,
            'data' => $article,
            'message' => 'Get data article successfull'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(ArticaleRequest $request)
    // {
    //     $data = $request->validated();
    //     if ($request->hasFile('thumbnail')) {
    //         $file = $request->file('thumbnail');
    //         $fileName = time() . '-' . $file->getClientOriginalName();

    //         $path = $file->storeAs('images', $fileName, 'public');
    //         $data['thumbnail'] = $path;
    //     }

    //     $article = Article::create($data);

    //     // ✅ Gửi thông báo tới tất cả subscriber
    //     $this->sendNotificationToSubscribers($article);

    //     return response()->json([
    //         'success' => true,
    //         'data' => $article,
    //         'message' => 'Add article successfull'
    //     ]);
    // }

    // public function store(ArticaleRequest $request)
    // {
    //     $data = $request->validated();

    //     if ($request->hasFile('thumbnail')) {
    //         $uploadedFileUrl = Cloudinary::upload($request->file('thumbnail')->getRealPath())->getSecurePath();
    //         $data['thumbnail'] = $uploadedFileUrl;
    //     }

    //     $article = Article::create($data);

    //     return response()->json([
    //         'success' => true,
    //         'data' => $article,
    //         'message' => 'Add article successfull'
    //     ]);
    // }

    public function store(ArticaleRequest $request)
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('thumbnail')) {
                $uploadedFileUrl = Cloudinary::upload($request->file('thumbnail')->getPathname())->getSecurePath();
                $data['thumbnail'] = $uploadedFileUrl;
            }

            $article = Article::create($data);

            return response()->json([
                'success' => true,
                'data' => $article,
                'message' => 'Add article successfull'
            ]);
        } catch (\Exception $e) {
            Log::error('Error when storing article: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Server Error: ' . $e->getMessage()
            ], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $article = Article::findOrFail($id);

        // dd([
        //     'eloquent' => $article,
        //     'raw' => DB::table('articles')->where('id', $id)->first()
        // ]);

        return response()->json([
            'success' => true,
            'data' => $article,
            'message' => 'Get data article successfull'
        ]);
    }


    public function update(ArticaleRequest $request, $id)
    {


        $article = Article::findOrFail($id);
        // $data = $request->validated(); // Lấy dữ liệu từ form
        $data = $request->only(['title', 'content', 'category_id']);


        // Kiểm tra và xử lý ảnh nếu có
        if ($request->hasFile('thumbnail')) {
            if ($article->thumbnail && Storage::disk('public')->exists($article->thumbnail)) {
                Storage::disk('public')->delete($article->thumbnail);
            }

            $file = $request->file('thumbnail');
            $fileName = time() . '-' . $file->getClientOriginalName();
            $path = $file->storeAs('images', $fileName, 'public');
            $data['thumbnail'] = $path;
        }

        // Nếu không có dữ liệu nào được gửi, trả về lỗi
        if (empty($data)) {
            return response()->json([
                'success' => false,
                'message' => 'Không có dữ liệu nào để cập nhật'
            ], 400);
        }

        // Cập nhật dữ liệu
        $article->update($data);

        return response()->json([
            'success' => true,
            'data' => $article->fresh(),
            'message' => 'Update article successful'
        ]);

        dd($article);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $article = Article::findOrFail($id);
        $article->delete();

        return response()->json([
            'success' => true,
            'message' => 'Xóa article thành công'
        ]);
    }

    protected function sendNotificationToSubscribers($article)
    {
        $subscribers = NewsletterSubscription::all();
        foreach ($subscribers as $subscriber) {
            Mail::to($subscriber->email)->send(new NewArticleNotification($article));
        }
    }
}
