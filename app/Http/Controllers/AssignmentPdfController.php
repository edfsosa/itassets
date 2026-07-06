<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use Barryvdh\DomPDF\Facade\Pdf;

class AssignmentPdfController extends Controller
{
    public function download(Assignment $assignment): \Illuminate\Http\Response
    {
        $pdf = Pdf::loadView('pdf.assignment', [
            'assignment' => $assignment->loadMissing('employee', 'assets'),
        ]);

        $employee = $assignment->employee;
        $filename = 'asignacion_' . ($employee?->legajo ?? $employee?->id ?? 'sin_empleado') . '_' . $assignment->id . '.pdf';

        return $pdf->stream($filename);
    }
}
