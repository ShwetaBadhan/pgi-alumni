<?php

namespace App\Http\Controllers;

use App\Models\AbstractSubmission;
use App\Models\AbstractCategory;
use App\Models\AbstractTheme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AlumniAbstractSubmissionController extends Controller
{
    // 1. Form Dikhayein
    public function create()
    {
        $categories = AbstractCategory::where('status', 1)->get();
        $themes = AbstractTheme::where('status', 1)->get();

        return view('frontend.pages.abstract-submit', compact('categories', 'themes'));
    }

    public function store(Request $request)
    {
        Log::info('=== ALUMNI ABSTRACT STORE STARTED ===');

        $user = Auth::guard('alumni')->user();
        if (!$user) {
            return redirect()->route('alumni-login')->with('error', 'Please login first.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'abstract_text' => 'required|string',
            'keywords' => 'nullable|string',
            'authors' => 'nullable|string',
            'co_author' => 'nullable|string',
            'primary_author_affiliation' => 'nullable|string',
            'category_id' => 'required|exists:abstract_categories,id',
            'theme_id' => 'required|exists:abstract_themes,id',
        ]);

        DB::beginTransaction();
        try {
            $action = $request->input('action', 'draft');

            $submission = AbstractSubmission::create([
                'user_id' => $user->id,
                'title' => $validated['title'],
                'abstract_text' => $validated['abstract_text'],
                'keywords' => $validated['keywords'] ?? null,
                'authors' => $validated['authors'] ?? null,
                'co_author' => $validated['co_author'] ?? null,
                'primary_author_affiliation' => $validated['primary_author_affiliation'] ?? null,
                'category_id' => $validated['category_id'],
                'theme_id' => $validated['theme_id'],
                'status' => $action === 'finalize' ? 'submitted' : 'draft',
                'edit_count' => 0, // ✅ Pehli baar banne par 0
            ]);

            DB::commit();
            return redirect()->route('alumni.abstract.my-submissions')->with('success', 'Abstract saved successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to submit abstract: ' . $e->getMessage())->withInput();
        }
    }

    // 3. My Submissions Dikhayein
    public function mySubmissions()
    {
        $userId = Auth::guard('alumni')->id();

        $finalizedSubmissions = AbstractSubmission::where('user_id', $userId)->where('status', 'submitted')->latest()->get();
        $incompleteSubmissions = AbstractSubmission::where('user_id', $userId)->where('status', 'draft')->latest()->get();
        $deletedSubmissions = AbstractSubmission::onlyTrashed()->where('user_id', $userId)->latest()->get();

        return view('frontend.pages.abstract-my-submissions', compact(
            'finalizedSubmissions',
            'incompleteSubmissions',
            'deletedSubmissions'
        ));
    }

    // 4. Edit Form
    public function edit($id)
    {
        $user = Auth::guard('alumni')->user();
        $submission = AbstractSubmission::find($id);

        if (!$submission) abort(404, 'Abstract not found.');
        if ($submission->user_id != $user->id) abort(403, 'Unauthorized.');

        if ($submission->edit_count >= 3) {
            return redirect()->route('alumni.abstract.my-submissions')
                ->with('error', 'You have reached the maximum limit of 3 edits. Please contact the admin for further changes.');
        }

        // ✅ Categories aur Themes wapas pass karein taaki dropdown dikhe
        $categories = \App\Models\AbstractCategory::where('status', 1)->get();
        $themes = \App\Models\AbstractTheme::where('status', 1)->get();

        return view('frontend.pages.abstract-submit', compact('submission', 'categories', 'themes'));
    }


    // 5. Update Submission
    public function update(Request $request, $id)
    {
        $user = Auth::guard('alumni')->user();
        $submission = AbstractSubmission::find($id);

        if (!$submission) return back()->with('error', 'Abstract not found.');
        if ($submission->user_id != $user->id) abort(403, 'Unauthorized.');

        if ($submission->edit_count >= 3) {
            abort(403, 'Edit limit reached. Contact admin.');
        }

        // ✅ VALIDATION: Category aur Theme yahan se HATA diye hain taaki user unhe change na kar sake
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'abstract_text' => 'required|string',
            'keywords' => 'nullable|string',
            'authors' => 'nullable|string',
            'co_author' => 'nullable|string',
            'primary_author_affiliation' => 'nullable|string',
            // category_id aur theme_id yahan nahi hain
        ]);

        DB::beginTransaction();
        try {
            $action = $request->input('action', 'draft');

            // ✅ UPDATE: Category aur Theme yahan update nahi ho rahe, purani value hi rahegi
            $submission->update([
                'title' => $validated['title'],
                'abstract_text' => $validated['abstract_text'],
                'keywords' => $validated['keywords'] ?? null,
                'authors' => $validated['authors'] ?? null,
                'co_author' => $validated['co_author'] ?? null,
                'primary_author_affiliation' => $validated['primary_author_affiliation'] ?? null,
                'status' => $action === 'finalize' ? 'submitted' : 'draft',
                'edit_count' => $submission->edit_count + 1, // ✅ Edit count badhao
            ]);

            DB::commit();
            $remaining = 3 - $submission->edit_count;
            $msg = $remaining > 0 ? "Abstract updated successfully! ({$remaining} edits remaining)" : "Abstract updated successfully! (No more edits allowed)";

            return redirect()->route('alumni.abstract.my-submissions')->with('success', $msg);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to update abstract: ' . $e->getMessage())->withInput();
        }
    }
    // 6. Delete Submission
    public function destroy(AbstractSubmission $submission)
    {
        // ✅ FIX: $user->id se compare karein
        if ($submission->user_id != Auth::guard('alumni')->id()) {
            abort(403, 'Unauthorized.');
        }
        $submission->delete();
        return back()->with('success', 'Abstract deleted successfully.');
    }

    // 7. Guidelines
    public function guidelines()
    {
        return view('frontend.pages.abstract-guidelines');
    }
}
