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

        $query = AbstractSubmission::with(['alumniUser', 'category', 'theme', 'reviewer', 'organizer'])->latest();

        // Filters
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        if ($request->filled('theme')) {
            $query->where('theme_id', $request->theme);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('keywords', 'like', "%{$search}%")
                    ->orWhereHas('alumniUser', function ($qu) use ($search) {
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
            'submissions',
            'categories',
            'themes',
            'tab',
            'isAdmin',
            'isOrganizer',
            'isReviewer'
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

            // Safe Log Creation
            if (class_exists(AbstractLog::class)) {
                AbstractLog::create([
                    'submission_id' => $submission->id,
                    'actor_type' => 'user',
                    'actor_id' => $currentUser->student_id ?? $currentUser->id,
                    'actor_name' => $currentUser->full_name ?? ($currentUser->firstname . ' ' . $currentUser->lastname),
                    'action' => 'submitted',
                    'remarks' => 'Abstract submitted successfully',
                ]);
            }

            DB::commit();
            return redirect()->route('abstract.submissions.index')->with('success', 'Abstract submitted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to submit abstract: ' . $e->getMessage());
        }
    }

    public function show(AbstractSubmission $submission)
    {
        $submission->load(['alumniUser', 'category', 'theme', 'reviewer', 'organizer']);
        return view('backend.pages.abstract.submissions.show', compact('submission'));
    }

    // ✅ CLEANED: Sirf ek hi edit method (Admin ke liye)
    public function edit(AbstractSubmission $submission)
    {
        $categories = AbstractCategory::where('status', 1)->get();
        $themes = AbstractTheme::where('status', 1)->get();

        return view('backend.pages.abstract.submissions.edit', compact('submission', 'categories', 'themes'));
    }

    // ✅ CLEANED: Sirf ek hi update method (Admin ke liye, saare fields ke saath)
    public function update(Request $request, AbstractSubmission $submission)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'authors' => 'nullable|string',
            'co_author' => 'nullable|string',
            'primary_author_affiliation' => 'nullable|string',
            'category_id' => 'required|exists:abstract_categories,id',
            'theme_id' => 'required|exists:abstract_themes,id',
            'abstract_text' => 'required|string',
            'keywords' => 'nullable|string',
            'status' => 'required|string',
            'reviewer_score' => 'nullable|numeric|min:0|max:10',
            'reviewer_remark' => 'nullable|string',
            'organizer_remark' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $submission->update([
                'title' => $validated['title'],
                'authors' => $validated['authors'],
                'co_author' => $validated['co_author'],
                'primary_author_affiliation' => $validated['primary_author_affiliation'],
                'category_id' => $validated['category_id'],
                'theme_id' => $validated['theme_id'],
                'abstract_text' => $validated['abstract_text'],
                'keywords' => $validated['keywords'],
                'status' => $validated['status'],
                'reviewer_score' => $validated['reviewer_score'],
                'reviewer_remark' => $validated['reviewer_remark'],
                'organizer_remark' => $validated['organizer_remark'],
            ]);

            // Safe Log Creation for Admin Update
            if (class_exists(AbstractLog::class)) {
                $currentUser = Auth::user();
                AbstractLog::create([
                    'submission_id' => $submission->id,
                    'actor_type' => 'admin',
                    'actor_id' => $currentUser->id,
                    'actor_name' => $currentUser->name ?? 'Admin',
                    'action' => 'updated_by_admin',
                    'remarks' => 'Abstract details updated by admin/organizer',
                ]);
            }

            DB::commit();
            return redirect()->route('abstract.submissions.index')->with('success', 'Abstract updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to update abstract: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(AbstractSubmission $submission)
    {
        $submission->delete();
        return redirect()->route('abstract.submissions.index')->with('success', 'Abstract deleted successfully.');
    }

    public function export(Request $request)
    {
        $user = Auth::user();
        if (!$user->hasRole('admin') && !$user->hasRole('organizer')) {
            abort(403, 'Unauthorized action.');
        }

        $query = AbstractSubmission::with(['alumniUser', 'category', 'theme']);

        if ($request->filled('category')) $query->where('category_id', $request->category);
        if ($request->filled('theme')) $query->where('theme_id', $request->theme);
        if ($request->filled('status')) $query->where('status', $request->status);

        $submissions = $query->get();

        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\AbstractSubmissionsExport($submissions),
            'abstract_submissions_' . date('Y-m-d') . '.xlsx'
        );
    }

    public function exportWord(AbstractSubmission $submission)
    {
        $submission->load(['category', 'theme', 'alumniUser', 'reviewer', 'organizer']);

        $authors = $submission->authors ?? 'N/A';
        $coAuthor = $submission->co_author ?? 'N/A';
        $categoryName = $submission->category ? $submission->category->name : 'N/A';
        $themeName = $submission->theme ? $submission->theme->name : 'N/A';
        $status = ucfirst(str_replace('_', ' ', $submission->status));
        $submittedOn = \Carbon\Carbon::parse($submission->created_at)->setTimezone('Asia/Kolkata')->format('d M Y, h:i A');
        $abstractText = nl2br(e($submission->abstract_text));

        $keywordsHtml = $submission->keywords ? "<h2>Keywords</h2><p>" . e($submission->keywords) . "</p>" : "";

        $reviewerHtml = "";
        if ($submission->reviewer) {
            $reviewerName = $submission->reviewer->name ?? $submission->reviewer->username ?? 'N/A';
            $score = $submission->reviewer_score ?? 'N/A';
            $remark = $submission->reviewer_remark ?? 'None';
            $reviewerHtml = "
                <h2>Reviewer Details</h2>
                <table class='info-table'>
                    <tr><td>Reviewer</td><td>{$reviewerName}</td></tr>
                    <tr><td>Score</td><td>{$score} / 10</td></tr>
                    <tr><td>Remark</td><td>{$remark}</td></tr>
                </table>
            ";
        }

        $exportDate = \Carbon\Carbon::now()->setTimezone('Asia/Kolkata')->format('d M Y, h:i A');

        $html = <<<HTML
        <html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:w='urn:schemas-microsoft-com:office:word' xmlns='http://www.w3.org/TR/REC-html40'>
        <head>
            <meta charset='utf-8'>
            <title>Abstract Export</title>
            <style>
                body { font-family: 'Calibri', sans-serif; font-size: 12pt; line-height: 1.5; margin: 40px; }
                h1 { color: #2c3e50; font-size: 18pt; border-bottom: 2px solid #3498db; padding-bottom: 10px; }
                h2 { color: #2980b9; font-size: 14pt; margin-top: 20px; }
                .info-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
                .info-table td { padding: 8px; border: 1px solid #ddd; }
                .info-table td:first-child { font-weight: bold; background: #f5f5f5; width: 30%; }
                .abstract-text { text-align: justify; background: #f9f9f9; padding: 15px; border-left: 4px solid #3498db; }
                .footer { margin-top: 40px; padding-top: 10px; border-top: 1px solid #ccc; font-size: 10pt; color: #777; text-align: center; }
            </style>
        </head>
        <body>
            <h1>Abstract Submission</h1>
            <h2>Submission Details</h2>
            <table class='info-table'>
                <tr><td>Title</td><td>{$submission->title}</td></tr>
                <tr><td>Authors</td><td>{$authors}</td></tr>
                <tr><td>Co-Author</td><td>{$coAuthor}</td></tr>
                <tr><td>Category</td><td>{$categoryName}</td></tr>
                <tr><td>Theme</td><td>{$themeName}</td></tr>
                <tr><td>Status</td><td>{$status}</td></tr>
                <tr><td>Submitted On</td><td>{$submittedOn}</td></tr>
            </table>
            <h2>Abstract</h2>
            <div class='abstract-text'>{$abstractText}</div>
            {$keywordsHtml}
            {$reviewerHtml}
            <div class='footer'>Exported from PGI Alumni System on {$exportDate}</div>
        </body>
        </html>
HTML;

        $filename = 'Abstract_' . preg_replace('/[^A-Za-z0-9]/', '_', $submission->title) . '.doc';

        return response($html)
            ->header('Content-Type', 'application/msword')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
}
