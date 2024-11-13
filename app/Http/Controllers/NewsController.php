<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewsController extends Controller
{
    // Menampilkan semua berita
    public function index()
    {
        $news = News::with('category')->paginate(10); // Pagination untuk efisiensi
        return response()->json([
            'message' => 'Get All Resource',
            'data' => $news
        ], 200);
    }

    // Menambah berita baru
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'required|string',
            'content' => 'required|string',
            'url' => 'required|string',
            'url_image' => 'required|string',
            'published_at' => 'nullable|date',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $news = News::create($request->all());

        return response()->json([
            'message' => 'Resource is added successfully',
            'data' => $news
        ], 201);
    }

    // Menampilkan detail berita berdasarkan ID
    public function show($id)
    {
        $news = News::with('category')->find($id);

        if (!$news) {
            return response()->json([
                'message' => 'Resource not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Get Detail Resource',
            'data' => $news
        ], 200);
    }

    // Memperbarui berita berdasarkan ID
    public function update(Request $request, $id)
    {
        $news = News::find($id);
        if (!$news) {
            return response()->json(['message' => 'Resource not found'], 404);
        }

        $news->update($request->all());

        return response()->json([
            'message' => 'Resource is updated successfully',
            'data' => $news
        ], 200);
    }

    // Menghapus berita berdasarkan ID
    public function destroy($id)
    {
        $news = News::find($id);
        if (!$news) {
            return response()->json(['message' => 'Resource not found'], 404);
        }

        $news->delete();

        return response()->json([
            'message' => 'Resource is deleted successfully'
        ], 200);
    }
}

