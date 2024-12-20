<?php

namespace App\Http\Controllers;
use App\Models\Report;
use App\Models\ResponseProgress;
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

    public function store(Request $request, $id)
    {
        // Validate the form data
        $request->validate([
            'description' => 'required|string',
            'response_id' => 'required|exists:reports,id', // Ensure the response_id exists in the reports table
        ]);

        // Check if the report exists
        $report = Report::find($id); // Assuming you're passing the report's ID here
        if (!$report) {
            return redirect()->back()->with('error', 'Report not found.');
        }

        // Create or find the response progress
        $responseProgress = ResponseProgress::firstOrCreate(
            ['response_id' => $id], // Ensure the response_id corresponds to the report
            ['histories' => json_encode([])] // Initialize histories as an empty array if the record doesn't exist
        );

        // Append the new progress description to the existing histories
        $histories = json_decode($responseProgress->histories, true); // Decode the existing histories from JSON
        $histories[] = ['description' => $request->description, 'created_at' => now()]; // Add the new progress entry

        // Save the updated response progress with the new history
        $responseProgress->histories = json_encode($histories); // Re-encode histories to JSON format
        $responseProgress->save();

        return redirect()->back()->with('success', 'Progress berhasil ditambahkan!');
    }
}
