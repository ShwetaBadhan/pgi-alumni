<?php

namespace App\Mail;

use App\Models\AbstractSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AbstractDecisionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $submission;
    public $decision;
    public $remark;

    public function __construct(AbstractSubmission $submission, string $decision, string $remark = '')
    {
        $this->submission = $submission;
        $this->decision = $decision;
        $this->remark = $remark;
    }

    public function build()
    {
        $subject = $this->decision === 'organizer_accepted'
            ? 'Abstract Accepted - ' . $this->submission->title
            : 'Abstract Not Accepted - ' . $this->submission->title;

        return $this->subject($subject)
                    ->view('emails.abstract.decision')
                    ->with([
                        'accepted' => $this->decision === 'organizer_accepted',
                        'remark' => $this->remark,
                        'title' => $this->submission->title,
                    ]);
    }
}