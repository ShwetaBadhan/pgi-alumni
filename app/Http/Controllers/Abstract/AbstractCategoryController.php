<?php

namespace App\Http\Controllers\Abstract;

use App\Http\Controllers\Controller;
use App\Models\AbstractCategory;
use Illuminate\Http\Request;

class AbstractCategoryController extends Controller
{
    public function index()
    {
        $categories = AbstractCategory::latest()->paginate(15);
        return view('backend.pages.abstract.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:abstract_categories,name',
            'status' => 'required|in:1,0',
        ]);

        AbstractCategory::create($validated);

        return redirect()->route('abstract.categories.index')
            ->with('success', 'Abstract Category added successfully!');
    }

    public function update(Request $request, AbstractCategory $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:abstract_categories,name,' . $category->id,
            'status' => 'required|in:1,0',
        ]);

        $category->update($validated);

        return redirect()->route('abstract.categories.index')
            ->with('success', 'Abstract Category updated successfully!');
    }

    public function destroy(AbstractCategory $category)
    {
        if ($category->submissions()->exists()) {
            return back()->with('error', 'Cannot delete this category as it is linked to existing abstract submissions.');
        }

        $category->delete();

        return redirect()->route('abstract.categories.index')
            ->with('success', 'Abstract Category deleted successfully!');
    }
}