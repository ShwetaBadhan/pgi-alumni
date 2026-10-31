<?php

namespace App\Http\Controllers\Abstract;

use App\Http\Controllers\Controller;
use App\Models\AbstractTheme;
use Illuminate\Http\Request;

class AbstractThemeController extends Controller
{
    public function index()
    {
        $themes = AbstractTheme::latest()->paginate(15);
        return view('backend.pages.abstract.themes.index', compact('themes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:abstract_themes,name',
            'status' => 'required|in:1,0',
        ]);

        AbstractTheme::create($validated);

        return redirect()->route('abstract.themes.index')
            ->with('success', 'Abstract Theme added successfully!');
    }

    public function update(Request $request, AbstractTheme $theme)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:abstract_themes,name,' . $theme->id,
            'status' => 'required|in:1,0',
        ]);

        $theme->update($validated);

        return redirect()->route('abstract.themes.index')
            ->with('success', 'Abstract Theme updated successfully!');
    }

    public function destroy(AbstractTheme $theme)
    {
        // Check if theme is linked to any submission (Optional but safe)
        if ($theme->submissions()->exists()) {
            return back()->with('error', 'Cannot delete this theme as it is linked to existing abstract submissions.');
        }

        $theme->delete();

        return redirect()->route('abstract.themes.index')
            ->with('success', 'Abstract Theme deleted successfully!');
    }
}