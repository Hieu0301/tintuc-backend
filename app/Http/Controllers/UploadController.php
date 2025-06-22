<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function uploadImage(Request $request)
    {
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '-' . $file->getClientOriginalName();

            $path = $file->storeAs('content-images', $fileName, 'public');

            return response()->json([
                'success' => true,
                'url' => asset('storage/' . $path),
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Không có ảnh']);
    }
}
