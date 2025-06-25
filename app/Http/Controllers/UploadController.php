<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    // public function uploadImage(Request $request)
    // {
    //     if ($request->hasFile('image')) {
    //         $file = $request->file('image');
    //         $fileName = time() . '-' . $file->getClientOriginalName();

    //         $path = $file->storeAs('content-images', $fileName, 'public');

    //         return response()->json([
    //             'success' => true,
    //             'url' => asset('storage/' . $path),
    //         ]);
    //     }

    //     return response()->json(['success' => false, 'message' => 'Không có ảnh']);
    // }


    public function uploadImage(Request $request)
    {
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '-' . $file->getClientOriginalName();

            // ✅ Lưu trực tiếp vào public/content-images (KHÔNG dùng storage)
            $file->move(public_path('content-images'), $fileName);

            // ✅ Trả về URL đúng public path
            return response()->json([
                'success' => true,
                'url' => asset('content-images/' . $fileName),
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Không có ảnh']);
    }
}
