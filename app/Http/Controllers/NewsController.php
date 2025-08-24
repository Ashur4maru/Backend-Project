<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['create', 'store']);
        $this->middleware('is_admin')->only(['create', 'store']);
    }

    public function index()
    {
        $news = News::latest()->get();
        return view('news.index', compact('news'));
    }

    public function create()
    {
        return view('news.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
        ]);

        News::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('news.index')->with('success', 'Nouvelle ajoutée avec succès.');
    }

    public function show(News $news)
    {
        return view('news.show', compact('news'));
    }
}