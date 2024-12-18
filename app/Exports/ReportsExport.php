<?php

namespace App\Exports;

use App\Models\Report;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReportsExport implements FromCollection, WithHeadings, WithMapping
{
    private $rowNumber = 0; // Variabel untuk nomor urut
    private $reports; // Variabel untuk menyimpan data laporan

    // Terima data melalui konstruktor
    public function __construct($reports = null)
    {
        $this->reports = $reports;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Jika data laporan diberikan, gunakan data tersebut
        if ($this->reports) {
            return $this->reports;
        }

        // Jika tidak, ambil semua laporan
        return Report::with('user')->get();
    }

    // Header kolom
    public function headings(): array
    {
        return [
            'No',
            'Email Pelapor',
            'Dilaporkan Pada Tanggal',
            'Deskripsi Pengaduan',
            'URL Gambar',
            'Lokasi',
            'Jumlah Voting',
            'Status Pengaduan',
            'Progress Pengaduan',
            'Staff Pengaduan',
        ];
    }

    public function map($report): array
    {
        // Increment nomor urut
        $this->rowNumber++;

        return [
            $this->rowNumber,
            $report->user->email ?? 'N/A',
            Carbon::parse($report->created_at)->locale('id')->isoFormat('dddd, D MMMM Y - H:mm:ss'),
            $report->description,
            $report->image ? url($report->image) : '-',
            $report->village . ', ' . $report->subdistrict . ', ' . $report->regency . ', ' . $report->province,
            $report->votes ?? '0',
            $report->status ?? 'Belum Ditanggapi',
            $report->progress ?? '',
            Auth::user()->email ?? 'Belum Ditanggapi',
        ];
    }
}
