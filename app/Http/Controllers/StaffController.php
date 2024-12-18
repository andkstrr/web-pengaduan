<?php

namespace App\Http\Controllers;
use App\Models\Report;
use App\Exports\ReportsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index(Request $request) {
        $sortOrder = $request->input('sort', 'desc'); // Default urutan adalah descending (terbanyak)

        $reports = Report::orderByRaw('LENGTH(votes) DESC')->get(); // Mengurutkan berdasarkan jumlah vote (terbanyak ke sedikit)

        // Jika ingin menambahkan pengurutan berdasarkan votes yang paling sedikit (ascending)
        if ($sortOrder === 'asc') {
            $reports = Report::orderByRaw('LENGTH(votes) ASC')->get();
        }

        return view('pages.staff.response.home', compact('reports', 'sortOrder'));
    }

    public function exportAll() {
        return Excel::download(New ReportsExport, 'pengaduan.xlsx');
    }

    public function exportByDate(Request $request)
    {
        $date = $request->date;

        if (!$date) {
            return back()->with('failed', 'Tanggal tidak valid!');
        }

        // Filter laporan berdasarkan tanggal
        $reports = Report::whereDate('created_at', $date)->get();

        // Periksa apakah ada data yang ditemukan
        if ($reports->isEmpty()) {
            return back()->with('failed', 'Tidak ada laporan untuk tanggal yang dipilih!');
        }

        // Kirim data ke export class
        return Excel::download(new ReportsExport($reports), 'pengaduan-' . $date . '.xlsx');
    }

    public function showStatus(Request $request, $id)
    {
        $reports = Report::findOrFail($id); // Ambil data berdasarkan id
        return view('pages.staff.response.status', compact('reports')); // Kirim data ke view
    }
}
