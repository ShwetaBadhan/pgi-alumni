<?php

namespace App\Http\Controllers\Abstract;

use App\Http\Controllers\Controller;
use App\Models\{AbstractReviewerAssignment, AbstractCategory, AbstractTheme, Admin};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AbstractReviewerController extends Controller
{
    public function index()
    {
        // Get all assignments with reviewer, category, and theme details
        $assignments = AbstractReviewerAssignment::with(['reviewer', 'category', 'theme'])
            ->latest()
            ->paginate(15);
            
        $reviewers = Admin::whereHas('roles', function($q) {
            $q->where('role_name', 'reviewer'); // Adjust based on your role logic
        })->get();
        
        $categories = AbstractCategory::where('status', 1)->get();
        $themes = AbstractTheme::where('status', 1)->get();

        return view('abstract.reviewers.index', compact('assignments', 'reviewers', 'categories', 'themes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'reviewer_id' => 'required|exists:admins,_id',
            'category_id' => 'required|exists:abstract_categories,id',
            'theme_id' => 'nullable|exists:abstract_themes,id',
            'status' => 'required|boolean',
        ]);

        // Check if this exact assignment already exists
        $exists = AbstractReviewerAssignment::where('reviewer_id', $validated['reviewer_id'])
            ->where('category_id', $validated['category_id'])
            ->where('theme_id', $validated['theme_id'] ?? null)
            ->exists();

        if ($exists) {
            return back()->with('error', 'This reviewer is already assigned to this category/theme combination.');
        }

        AbstractReviewerAssignment::create($validated);

        return redirect()->route('abstract.reviewers.index')
            ->with('success', 'Reviewer assigned successfully!');
    }

    public function updateStatus(Request $request, AbstractReviewerAssignment $assignment)
    {
        $request->validate([
            'status' => 'required|boolean'
        ]);

        $assignment->update(['status' => $request->status]);

        return back()->with('success', 'Reviewer assignment status updated!');
    }

    public function destroy(AbstractReviewerAssignment $assignment)
    {
        $assignment->delete();

        return redirect()->route('abstract.reviewers.index')
            ->with('success', 'Reviewer assignment removed successfully!');
    }
    
    // Optional: Auto-assign pending abstracts to reviewers based on this logic
    public function reroutePending()
    {
        DB::transaction(function () {
            $pendingSubmissions = \App\Models\AbstractSubmission::whereIn('status', ['submitted', 'resubmitted', 'sent_to_reviewer'])->get();

            foreach ($pendingSubmissions as $submission) {
                // Find reviewer: Prefer exact category+theme match, else just category
                $assignment = AbstractReviewerAssignment::where('category_id', $submission->category_id)
                    ->where(function($q) use ($submission) {
                        $q->where('theme_id', $submission->theme_id)
                          ->orWhereNull('theme_id');
                    })
                    ->where('status', 1)
                    ->orderBy('id', 'asc')
                    ->first();

                if ($assignment) {
                    $submission->update([
                        'reviewer_id' => $assignment->reviewer_id,
                        'status' => 'sent_to_reviewer'
                    ]);
                }
            }
        });

        return back()->with('success', 'Pending abstracts have been re-routed to reviewers successfully!');
    }
}