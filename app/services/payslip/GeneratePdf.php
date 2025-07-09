<?php

namespace App\Services\Payslip;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

class GeneratePdf
{
    /**
     * Génère un objet PDF à partir des données fournies.
     *
     * @param array $data
     * @return \Barryvdh\DomPDF\PDF
     */
     public function generate(array $data)
     {
         return Pdf::loadView('pdf.payslip', $data);
    }


     public function downloadPdf(array $data, string $filename = 'fiche-de-paie.pdf')
     {
        try {
            return Pdf::loadView('pdf.payslip', $data);
        } catch (\Exception $e) {
            // Optionnel : log de l’erreur
             Log::error($e->getMessage());
         }
     }
}
