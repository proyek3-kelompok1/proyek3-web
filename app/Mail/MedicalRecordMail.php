<?php

namespace App\Mail;

use App\Models\MedicalRecord;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;

class MedicalRecordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $medicalRecord;

    public function __construct(MedicalRecord $medicalRecord)
    {
        $this->medicalRecord = $medicalRecord;
    }

    public function build()
    {
        $pdf = Pdf::loadView('admin.medical-records.pdf', ['medicalRecord' => $this->medicalRecord]);
        $pdf->setPaper('A4', 'portrait');

        return $this->subject('Rekam Medis DVPets - ' . $this->medicalRecord->nama_hewan)
                    ->view('emails.medical-record')
                    ->attachData($pdf->output(), 'Rekam_Medis_' . $this->medicalRecord->kode_rekam_medis . '.pdf', [
                        'mime' => 'application/pdf',
                    ]);
    }
}
