<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Response;
use Illuminate\Support\Facades\Auth;

class ResponseController extends Controller
{
    public function setStatus($id)
    {
        // Ambil laporan berdasarkan ID
        $report = Report::findOrFail($id);

        // Cek apakah user adalah STAFF
        if (Auth::user()->role === 'STAFF') {
            // Cek apakah response sudah ada untuk report ini
            $response = Response::where('report_id', $report->id)->first();

            if ($response) {
                // Update status jika response sudah ada
                $response->update(['response_status' => 'ON_PROCESS']);
            } else {
                // Buat response baru jika belum ada
                Response::create([
                    'report_id' => $report->id,
                    'response_status' => 'ON_PROCESS',
                    'staff_id' => Auth::id(),
                ]);
            }
        }

        // Redirect kembali ke halaman staff.home dengan pesan sukses
        return redirect()->route('responses.status')->with('success', 'Status berhasil diubah menjadi ON_PROCESS');
    }
}
