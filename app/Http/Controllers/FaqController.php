<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FaqController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index']);
        $this->middleware('is_admin')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    public function index()
    {
        $categories = FaqCategory::with('faqs')->get();
        return view('faqs.index', compact('categories'));
    }

    public function create()
    {
        $categories = FaqCategory::all();
        return view('faqs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:category,faq',
            'name' => 'required_if:type,category|string|max:255|unique:faq_categories,name',
            'faq_category_id' => 'required_if:type,faq|exists:faq_categories,id',
            'question' => 'required_if:type,faq|string',
            'answer' => 'required_if:type,faq|string',
        ]);

        if ($request->type === 'category') {
            FaqCategory::create(['name' => $request->name]);
        } else {
            Faq::create([
                'faq_category_id' => $request->faq_category_id,
                'user_id' => Auth::id(),
                'question' => $request->question,
                'answer' => $request->answer,
            ]);
        }

        return redirect()->route('faqs.index')->with('success', 'Ajout effectué avec succès.');
    }

    public function edit($id, $type)
    {
        $categories = FaqCategory::all();
        if ($type === 'category') {
            $item = FaqCategory::findOrFail($id);
        } else {
            $item = Faq::findOrFail($id);
        }
        return view('faqs.edit', compact('item', 'type', 'categories'));
    }

    public function update(Request $request, $id, $type)
    {
        $request->validate([
            'name' => 'required_if:type,category|string|max:255|unique:faq_categories,name,' . $id,
            'faq_category_id' => 'required_if:type,faq|exists:faq_categories,id',
            'question' => 'required_if:type,faq|string',
            'answer' => 'required_if:type,faq|string',
        ]);

        if ($type === 'category') {
            $category = FaqCategory::findOrFail($id);
            $category->update(['name' => $request->name]);
        } else {
            $faq = Faq::findOrFail($id);
            $faq->update([
                'faq_category_id' => $request->faq_category_id,
                'question' => $request->question,
                'answer' => $request->answer,
            ]);
        }

        return redirect()->route('faqs.index')->with('success', 'Mise à jour effectuée avec succès.');
    }

    public function destroy($id, $type)
    {
        if ($type === 'category') {
            FaqCategory::findOrFail($id)->delete();
        } else {
            Faq::findOrFail($id)->delete();
        }

        return redirect()->route('faqs.index')->with('success', 'Suppression effectuée avec succès.');
    }
}