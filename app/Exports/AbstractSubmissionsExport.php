<?php

namespace App\Exports;

use App\Models\AbstractSubmission;
use Maatwebsite\Excel\Concerns\{FromCollection, WithHeadings, WithMapping};

class AbstractSubmissionsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $submissions;

    public function __construct($submissions)
    {
        $this->submissions = $submissions;
    }

    public function collection()
    {
        return $this->submissions;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Title',
            'Author',
            'Email',
            'Category',
            'Theme',
            'Status',
            'Reviewer',
            'Score',
            'Organizer Decision',
            'Submitted At'
        ];
    }

    public function map($submission): array
    {
        return [
            $submission->id,
            $submission->title,
            $submission->user->full_name,
            $submission->user->email,
            $submission->category->name ?? 'N/A',
            $submission->theme->name ?? 'N/A',
            ucfirst(str_replace('_', ' ', $submission->status)),
            $submission->reviewer->username ?? 'Unassigned',
            $submission->reviewer_score ?? '-',
            $submission->organizer_remark ?? '-',
            $submission->created_at->format('d M Y'),
        ];
    }
}
