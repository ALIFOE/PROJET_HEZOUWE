<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::orderBy('date', 'desc')->paginate(15);
        return Inertia::render('Admin/News/Index', ['news' => $news]);
    }

    public function create()
    {
        return Inertia::render('Admin/News/Create');
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'images'   => 'required|array',
            'images.*' => 'required|image|max:4096',
        ]);

        $paths = [];
        foreach ($request->file('images') as $image) {
            $paths[] = '/storage/' . $image->store('news', 'public');
        }

        return response()->json(['images' => $paths]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'slug' => 'required|string|unique:news',
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'tag' => 'nullable|array',
            'author' => 'required|string|max:100',
            'date' => 'required|date',
            'excerpt' => 'required|string',
            'intro' => 'required|string',
            'body' => 'nullable|array',
            'quote' => 'nullable|string',
            'conclusion' => 'nullable|string',
            'read' => 'nullable|integer|min:1',
            'comments' => 'nullable|integer|min:0',
            'image' => 'required|string',
            'thumb' => 'nullable|string',
            'image2' => 'nullable|string',
            'image3' => 'nullable|string',
        ]);

        News::create($validated);

        return redirect()->route('admin.news.index')->with('success', 'Actualité créée avec succès');
    }

    public function edit(News $news)
    {
        return Inertia::render('Admin/News/Edit', ['news' => $news]);
    }

    public function update(Request $request, News $news)
    {
        $validated = $request->validate([
            'slug' => 'required|string|unique:news,slug,' . $news->id,
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'tag' => 'nullable|array',
            'author' => 'required|string|max:100',
            'date' => 'required|date',
            'excerpt' => 'required|string',
            'intro' => 'required|string',
            'body' => 'nullable|array',
            'quote' => 'nullable|string',
            'conclusion' => 'nullable|string',
            'read' => 'nullable|integer|min:1',
            'comments' => 'nullable|integer|min:0',
            'image' => 'required|string',
            'thumb' => 'nullable|string',
            'image2' => 'nullable|string',
            'image3' => 'nullable|string',
        ]);

        $news->update($validated);

        return redirect()->route('admin.news.index')->with('success', 'Actualité mise à jour avec succès');
    }

    public function destroy(News $news)
    {
        $news->delete();
        return redirect()->route('admin.news.index')->with('success', 'Actualité supprimée avec succès');
    }
}
