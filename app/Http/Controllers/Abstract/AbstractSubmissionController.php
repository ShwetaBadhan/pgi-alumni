<?php

namespace App\Http\Controllers\Abstract;

use App\Http\Controllers\Controller;
use App\Models\{AbstractSubmission, AbstractCategory, AbstractTheme, AbstractLog};
use App\Mail\AbstractDecisionMail;
use Illuminate\Http\{Request, JsonResponse};
use Illuminate\Support\Facades\{Auth, DB, Mail, Storage};
use Illuminate\Validation\Rule;

class AbstractSubmissionController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $isAdmin = $user->hasRole('admin');
        $isOrganizer = $user->hasRole('organizer');
        $isReviewer = $user->hasRole('reviewer');

        // ✅ 'alumniUser' relationship use kar rahe hain
        $query = AbstractSubmission::with(['alumniUser', 'category', 'theme', 'reviewer', 'organizer'])
            ->latest();

        // Filters
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('theme')) {
            $query->where('theme_id', $request->theme);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('keywords', 'like', "%{$search}%")
                  ->orWhereHas('alumniUser', function($qu) use ($search) {
                      $qu->where('firstname', 'like', "%{$search}%")
                        ->orWhere('lastname', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Tab filtering
        $tab = $request->get('tab', 'others'); 
        if ($tab === 'needs_decision') {
            $query->whereIn('status', ['submitted', 'resubmitted', 'reviewer_accepted']);
        } elseif ($tab === 'accepted') {
            $query->where('status', 'organizer_accepted');
        } elseif ($tab === 'others') {
            $query->whereNotIn('status', ['reviewer_accepted', 'organizer_accepted']);
        }

        // Role-based filtering
        if ($isOrganizer && !$isAdmin) {
            $query->where('status', 'reviewer_accepted');
        }

        if ($isReviewer && !$isAdmin) {
            $query->where('reviewer_id', $user->admin_id ?? $user->id);
        }

        $submissions = $query->paginate(15);
        $categories = AbstractCategory::where('status', 1)->orderBy('name')->get();
        $themes = AbstractTheme::where('status', 1)->orderBy('name')->get();

        return view('backend.pages.abstract.submissions.index', compact(
            'submissions', 'categories', 'themes', 'tab', 'isAdmin', 'isOrganizer', 'isReviewer'
        ));
    }

    public function create()
    {
        $categories = AbstractCategory::where('status', 1)->get();
        $themes = AbstractTheme::where('status', 1)->get();

        return view('abstract.submissions.create', compact('categories', 'themes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'abstract_text' => 'required|string',
            'keywords' => 'nullable|string',
            'category_id' => 'required|exists:abstract_categories,id',
            'theme_id' => 'required|exists:abstract_themes,id',
            'files.*' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        DB::beginTransaction();
        try {
            $currentUser = Auth::user();
            $submission = AbstractSubmission::create([
                'user_id' => $currentUser->student_id ?? $currentUser->id,
                'title' => $validated['title'],
                'abstract_text' => $validated['abstract_text'],
                'keywords' => $validated['keywords'] ?? null,
                'category_id' => $validated['category_id'],
                'theme_id' => $validated['theme_id'],
                'status' => 'submitted',
            ]);

            // Handle file uploads
            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    $path = $file->store('abstracts', 'public');
                    $submission->files()->create([
                        'file_path' => $path,
                        'file_type' => $file->getMimeType(),
                        'file_size' => $file->getSize(),
                    ]);
                }
            }

            // Log creation
            AbstractLog::create([
                'submission_id' => $submission->id,
                'actor_type' => 'user',
                'actor_id' => $currentUser->student_id ?? $currentUser->id,
                'actor_name' => $currentUser->full_name ?? ($currentUser->firstname . ' ' . $currentUser->lastname),
                'action' => 'submitted',
                'remarks' => 'Abstract submitted successfully',
            ]);

            // Send notification email
            Mail::to($currentUser->email)
                ->send(new \App\Mail\AbstractReceivedMail($submission));

            DB::commit();

            return redirect()->route('abstract.submissions.index')
                ->with('success', 'Abstract submitted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to submit abstract: ' . $e->getMessage());
        }
    }

    // ✅ authorize() hata diya gaya hai
      public function show(AbstractSubmission $submission)
    {
        // ✅ 'files' aur 'logs' hata diye hain kyunki unke columns database me missing hain
        $submission->load(['alumniUser', 'category', 'theme', 'reviewer', 'organizer']);

        return view('backend.pages.abstract.submissions.show', compact('submission'));
    }

    // ✅ authorize() hata diya gaya hai
    public function edit(AbstractSubmission $submission)
    {
        $categories = AbstractCategory::where('status', 1)->get();
        $themes = AbstractTheme::where('status', 1)->get();

        return view('abstract.submissions.edit', compact('submission', 'categories', 'themes'));
    }

    // ✅ authorize() hata diya gaya hai
    public function update(Request $request, AbstractSubmission $submission)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'abstract_text' => 'required|string',
            'keywords' => 'nullable|string',
            'category_id' => 'required|exists:abstract_categories,id',
            'theme_id' => 'required|exists:abstract_themes,id',
            'files.*' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        DB::beginTransaction();
        try {
            $submission->update([
                'title' => $validated['title'],
                'abstract_text' => $validated['abstract_text'],
                'keywords' => $validated['keywords'] ?? null,
                'category_id' => $validated['category_id'],
                'theme_id' => $validated['theme_id'],
                'status' => 'resubmitted',
            ]);

            // Handle new file uploads
            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    $path = $file->store('abstracts', 'public');
                    $submission->files()->create([
                        'file_path' => $path,
                        'file_type' => $file->getMimeType(),
                        'file_size' => $file->getSize(),
                    ]);
                }
            }

            $currentUser = Auth::user();
            AbstractLog::create([
                'submission_id' => $submission->id,
                'actor_type' => 'user',
                'actor_id' => $currentUser->student_id ?? $currentUser->id,
                'actor_name' => $currentUser->full_name ?? ($currentUser->firstname . ' ' . $currentUser->lastname),
                'action' => 'resubmitted',
                'remarks' => 'Abstract resubmitted with updates',
            ]);

            DB::commit();

            return redirect()->route('abstract.submissions.index')
                ->with('success', 'Abstract updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to update abstract.');
        }
    }

    // ✅ authorize() hata diya gaya hai
    public function destroy(AbstractSubmission $submission)
    {
        $submission->delete();

        return redirect()->route('abstract.submissions.index')
            ->with('success', 'Abstract deleted successfully.');
    }

    // ✅ authorize() hata diya gaya hai, sirf basic admin check rakha hai
    public function export(Request $request)
    {
        $user = Auth::user();
        if (!$user->hasRole('admin') && !$user->hasRole('organizer')) {
            abort(403, 'Unauthorized action.');
        }

        $query = AbstractSubmission::with(['alumniUser', 'category', 'theme']);

        // Apply same filters as index
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        if ($request->filled('theme')) {
            $query->where('theme_id', $request->theme);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $submissions = $query->get();

        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\AbstractSubmissionsExport($submissions),
            'abstract_submissions_' . date('Y-m-d') . '.xlsx'
        );
    }
}