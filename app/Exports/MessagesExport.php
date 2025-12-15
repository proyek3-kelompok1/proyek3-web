<?php

namespace App\Exports;

use App\Models\Feedback;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MessagesExport implements FromCollection, WithHeadings, WithMapping
{
    protected $startDate;
    protected $endDate;
    protected $rating;

    public function __construct($startDate = null, $endDate = null, $rating = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->rating = $rating;
    }

    public function collection()
    {
        $query = Feedback::with('consultation')
            ->orderBy('created_at', 'desc');

        if ($this->startDate) {
            $query->whereDate('created_at', '>=', $this->startDate);
        }

        if ($this->endDate) {
            $query->whereDate('created_at', '<=', $this->endDate);
        }

        if ($this->rating) {
            $query->where('rating', $this->rating);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama',
            'Email',
            'Telepon',
            'Rating',
            'Pesan',
            'Sumber',
            'Jenis Hewan',
            'Layanan',
            'Status',
            'Tanggal Dibuat',
            'Terakhir Diupdate',
        ];
    }

    public function map($feedback): array
    {
        $services = $feedback->consultation 
            ? json_decode($feedback->consultation->services, true) 
            : null;

        return [
            $feedback->id,
            $feedback->name,
            $feedback->consultation ? $feedback->consultation->email : '-',
            $feedback->consultation ? $feedback->consultation->phone : '-',
            $feedback->rating . '/5',
            $feedback->message,
            $this->getSourceText($feedback->source),
            $feedback->consultation ? $feedback->consultation->pet_type : '-',
            $services ? implode(', ', $services) : '-',
            $feedback->is_read ? 'Dibaca' : 'Baru',
            $feedback->created_at->format('d/m/Y H:i'),
            $feedback->updated_at->format('d/m/Y H:i'),
        ];
    }

    private function getSourceText($source)
    {
        $sources = [
            'consultation' => 'Konsultasi',
            'after_service' => 'Setelah Layanan'
        ];

        return $sources[$source] ?? $source;
    }
}