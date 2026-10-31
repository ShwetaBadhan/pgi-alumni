<?php

namespace App\Http\Controllers\Abstract;

use App\Http\Controllers\Controller;
use App\Models\{AbstractSubmission, AbstractLog};
use App\Mail\AbstractDecisionMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, DB, Mail};

class AbstractOrganizerController extends Controller
{
    public function decide(Request $request, AbstractSubmission $submission)
    {
        $this->authorize('decide', $submission);

        $validated = $request->validate([
            'decision' => 'required|in:accept,decline',
            'remark' => 'required_if:decision,decline|string',
        ]);

        DB::beginTransaction();
        try {
            $isAccept = $validated['decision'] === 'accept';
            $newStatus = $isAccept ? 'organizer_accepted' : 'organizer_rejected';
            $template = $isAccept ? 'organizer_accepted' : 'organizer_rejected';

            $submission->update([
                'status' => $newStatus,
                'organizer_id' => Auth::user()->admin_id,
                'organizer_remark' => $validated['remark'] ?? null,
                'organizer_decided_at' => now(),
            ]);

            AbstractLog::create([
                'submission_id' => $submission->id,
                'actor_type' => 'organizer',
                'actor_id' => Auth::user()->admin_id,
                'actor_name' => Auth::user()->username,
                'action' => $newStatus,
                'remarks' => $validated['remark'] ?? null,
            ]);

            // Send email notification
            Mail::to($submission->user->email)
                ->send(new AbstractDecisionMail($submission, $template, $validated['remark'] ?? ''));

            DB::commit();

            $message = $isAccept ? 'Abstract accepted successfully!' : 'Abstract declined successfully.';
            return redirect()->route('abstract.submissions.index')
                ->with('success', $message);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to record decision.');
        }
    }

    public function bulkDecide(Request $request)
    {
        $this->authorize('decideBulk');

        $validated = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:abstract_submissions,id',
            'decision' => 'required|in:accept,decline',
            'remark' => 'required_if:decision,decline|string',
        ]);

        $processed = 0;
        $skipped = 0;

        foreach ($validated['ids'] as $id) {
            $submission = AbstractSubmission::find($id);

            if (!$submission || !$submission->canBeDecidedByOrganizer()) {
                $skipped++;
                continue;
            }

            $this->decide($request, $submission);
            $processed++;
        }

        return redirect()->route('abstract.submissions.index')
            ->with('success', "{$processed} abstract(s) processed. {$skipped} skipped.");
    }
}