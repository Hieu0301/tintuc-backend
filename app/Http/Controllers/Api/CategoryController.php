<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = Category::all();
        return response()->json([
            'success' => true,
            'data' => $category,
            'message' => 'Get data categories successfull'
        ]);
    }

    public function articles($id)
    {
        $category = Category::findOrFail($id);

        $articles = Article::where('category_id', $id)->latest()->get();

        return response()->json([
            'success' => true,
            'category' => $category->name,
            'data' => $articles,
            'message' => 'Get articles by category successfull'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $data = $request->validated();
        $category = Category::create($data);

        return response()->json([
            'success' => true,
            'data' => $category,
            'message' => 'Add categories successfull'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $category,
            'message' => 'Get data categories successfull'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id)
    {
        $category = Category::findOrFail($id);
        $data = $request->validated();

        $category->update($data);

        return response()->json([
            'success' => true,
            'data' => $category,
            'message' => 'Update categories successfull'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);

        $category->delete();
        return response()->json([
            'success' => true,
            'message' => 'Delete categories successfull'
        ]);
    }
}
