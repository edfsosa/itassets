<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use Barryvdh\DomPDF\Facade\Pdf;

class AssignmentPdfController extends Controller
{
    public function download(Assignment $assignment)
    {
        $pdf = Pdf::loadView('pdf.assignment', [
            'assignment' => $assignment->loadMissing('employee', 'assets'),
        ]);

        $filename = 'asignacion_' . ($assignment->employee->legajo ?? $assignment->employee->id) . '_' . $assignment->id . '.pdf';

        return $pdf->stream($filename);
    }
}
