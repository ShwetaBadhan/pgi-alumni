<?php

namespace App\Http\Controllers;

use App\Models\AbstractSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AlumniAbstractSubmissionController extends Controller
{
    // 1. Form Dikhayein
    public function create()
    {
        return view('frontend.pages.abstract-submit');
    }

       // 2. Submission Store Karein
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
        ]);

        DB::beginTransaction();
        try {
            $action = $request->input('action', 'draft');
            
            $defaultCategoryId = \App\Models\AbstractCategory::first()?->id ?? 1;
            $defaultThemeId = \App\Models\AbstractTheme::first()?->id ?? 1;

            $submission = AbstractSubmission::create([
                // ✅ YAHAN CHANGE KIYA: $user->id ki jagah $user->membership_id
                'user_id' => $user->membership_id, 
                
                'title' => $validated['title'],
                'abstract_text' => $validated['abstract_text'],
                'keywords' => $validated['keywords'] ?? null,
                'authors' => $validated['authors'] ?? null,
                'co_author' => $validated['co_author'] ?? null,
                'primary_author_affiliation' => $validated['primary_author_affiliation'] ?? null,
                'category_id' => $defaultCategoryId, 
                'theme_id' => $defaultThemeId,    
                'status' => $action === 'finalize' ? 'submitted' : 'draft',
            ]);

            DB::commit();
            Log::info('✅ Abstract Saved Successfully!');

            $message = $action === 'finalize' ? 'Abstract finalized successfully!' : 'Abstract saved as draft!';
            return redirect()->route('alumni.abstract.my-submissions')->with('success', $message);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('❌ Abstract Save Failed: ' . $e->getMessage());
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
            'finalizedSubmissions', 'incompleteSubmissions', 'deletedSubmissions'
        ));
    }

    // 4. Edit Form
    public function edit(AbstractSubmission $submission)
    {
        if ($submission->user_id != Auth::guard('alumni')->id()) {
            abort(403, 'Unauthorized.');
        }
        return view('frontend.pages.abstract-submit', compact('submission'));
    }

    // 5. Update Submission
    public function update(Request $request, AbstractSubmission $submission)
    {
        $user = Auth::guard('alumni')->user();
       
        if ($submission->user_id != $user->membership_id) {
            abort(403, 'Unauthorized.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'abstract_text' => 'required|string',
            'keywords' => 'nullable|string',
            'authors' => 'nullable|string',
            'co_author' => 'nullable|string',
            'primary_author_affiliation' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $action = $request->input('action', 'draft');

            $submission->update([
                'title' => $validated['title'],
                'abstract_text' => $validated['abstract_text'],
                'keywords' => $validated['keywords'] ?? null,
                'authors' => $validated['authors'] ?? null,
                'co_author' => $validated['co_author'] ?? null,
                'primary_author_affiliation' => $validated['primary_author_affiliation'] ?? null,
                'status' => $action === 'finalize' ? 'submitted' : 'draft',
            ]);

            DB::commit();
            return redirect()->route('alumni.abstract.my-submissions')->with('success', 'Abstract updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to update abstract.')->withInput();
        }
    }

    // 6. Delete Submission
    public function destroy(AbstractSubmission $submission)
    {
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