<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\View\View;
use App\Models\User;
use App\Notifications\NewArticleNotification;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::latest()->get();
        return view('articles.index', compact('articles'));
    }

    public function create():view
    {
        return view('articles.create');
    }

    public function store(Request $request)
{
    $this->validate($request, [
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'image_url' => 'nullable|url',
        'author' => 'required|string|max:255',
        'link' => 'nullable|url',
    ]);

    // Simpan artikel dulu ke variabel agar bisa dipakai di notifikasi
    $article = Article::create([
        'title' => $request->title,
        'content' => $request->content,
        'image_url' => $request->image_url,
        'author' => $request->author,
        'link' => $request->link,
    ]);

    // Kirim notifikasi ke semua user (kecuali admin kalau mau)
    foreach (User::all() as $user) {
        // Kalau mau kecuali admin, bisa cek disini misal $user->is_admin
        $user->notify(new NewArticleNotification($article->title));
    }

    return redirect()->route('articles.index')->with('success', 'Article created successfully.');
}

    public function show($id)
    {
        $article = Article::findOrFail($id);
        return view('articles.show', compact('article'));
    }
    
    public function edit(string $id):view
    {
        $article = Article::findOrFail($id);
        return view('articles.edit', compact('article'));
    }

    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image_url' => 'nullable|url',
            'author' => 'required|string|max:255',
            'link' => 'nullable|url',
        ]);

        $article = Article::findOrFail($id);
        $article->update([
            'title' => $request->title,
            'content' => $request->content,
            'image_url' => $request->image_url,
            'author' => $request->author,
            'link' => $request->link,
        ]);

        return redirect()->route('articles.index')->with('success', 'Article updated successfully.');
    }

    public function destroy(string $id)
    {
        $article = Article::findOrFail($id);
        $article->delete();

        return redirect()->route('articles.index')->with('success', 'Article deleted successfully.');
    }
}
