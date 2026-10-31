<?php

namespace App\Policies;

use App\Models\User;
use App\Models\AbstractSubmission;

class AbstractSubmissionPolicy
{
    public function view(User $user, AbstractSubmission $submission)
    {
        // User can view their own submission
        if ($submission->user_id === $user->student_id) {
            return true;
        }

        // Admins, organizers, reviewers can view all
        return $user->hasAnyRole(['admin', 'organizer', 'reviewer']);
    }

    public function update(User $user, AbstractSubmission $submission)
    {
        // Only owner can update if status allows
        if ($submission->user_id === $user->student_id) {
            return in_array($submission->status, ['submitted', 'sent_back', 'resubmitted']);
        }

        return false;
    }

    public function delete(User $user, AbstractSubmission $submission)
    {
        return $user->hasRole('admin') ||
               ($submission->user_id === $user->student_id && $submission->status === 'submitted');
    }

    public function decide(User $user, AbstractSubmission $submission)
    {
        return $user->hasAnyRole(['admin', 'organizer']) &&
               $submission->canBeDecidedByOrganizer();
    }

    public function decideBulk(User $user)
    {
        return $user->hasAnyRole(['admin', 'organizer']);
    }

    public function exportAbstracts(User $user)
    {
        return $user->hasAnyRole(['admin', 'organizer']);
    }
}