<?php

namespace App\Mail;

use App\Models\AbstractSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AbstractReceivedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $submission;

    public function __construct(AbstractSubmission $submission)
    {
        $this->submission = $submission;
    }

    public function build()
    {
        return $this->subject('Abstract Received - ' . $this->submission->title)
                    ->view('emails.abstract.received')
                    ->with([
                        'title' => $this->submission->title,
                        'category' => $this->submission->category->name ?? 'N/A',
                        'theme' => $this->submission->theme->name ?? 'N/A',
                    ]);
    }
}