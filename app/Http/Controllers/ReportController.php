<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class ReportController extends Controller
{
    public function index() {
        $reports = Report::with('user')->get();
        return view('pages.guest.reports.home', compact('reports'));
    }

    public function showCreateForm() {
        return view('pages.guest.reports.create-report');
    }

    public function store(Request $request) {
        // Validasi inputan form
        $request->validate([
            'provinsi' => 'required',
            'kota' => 'required',
            'kecamatan' => 'required',
            'kelurahan' => 'required',
            'type' => 'required',
            'detail' => 'required',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'check' => 'accepted',
        ]);

        // Menyimpan gambar ke storage
        $imagePath = $request->file('gambar')->store('public/reports');
        function getName($name) {
            $result = explode('-', $name);
            return $result[1];
        }

        Report::create([
            'user_id' => Auth::id(),  // Menyimpan ID pengguna yang terautentikasi
            'description' => $request->detail,
            'type' => $request->type,
            'province' => getName($request->provinsi),
            'regency' => getName($request->kota),
            'subdistrict' => getName($request->kecamatan),
            'village' => getName($request->kelurahan),
            'image' => $imagePath,
            'statement' => $request->check ? '1' : '0',  // checkbox
        ]);

        return redirect()->route('reports.showAll')->with('success', 'Laporan berhasil dikirim');
    }

    public function search(Request $request)
    {
        $province = $request->province;
        if (!$province) {
            return redirect()->route('home')->with('failed', 'Pilih provinsi terlebih dahulu!');
        }

        $reports = Report::where('province', 'LIKE',     '%' . $province . '%')->get();

        return view('pages.guest.reports.home', compact('reports'));
    }


    public function showDetailComment($id)
    {
        $reports = Report::with('user')->findOrFail($id);
        $reports->increment('viewers', 1);
        $reports->save();
        $comments = $reports->comments()->with('user')->latest()->get();

        return view('pages.guest.reports.detail-comment', compact('reports', 'comments'));
    }

    public function storeComment(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        $reports = Report::findOrFail($id);

        $reports->comments()->create([
            'user_id' => Auth()->id(),
            'comment' => $request->comment
        ]);

        return redirect()->route('reports.comment', $id)->with('success', 'Komentar berhasil ditambahkan!');
    }

    public function deleteReport($id)
    {
        $proses = Report::where('id', $id)->delete();
        if ($proses) {
            return redirect()->back()->with('success', 'Berhasil menghapus laporan pengaduan!');
        } else {
            return redirect()->back()->with('failed', 'Gagal menghapus laporan pengaduan!');
        }
    }

    public function voteReport($id)
    {
        $report = Report::findOrFail($id); // Mencari laporan berdasarkan ID

        // Cek apakah user sudah memberikan vote sebelumnya
        $userId = Auth::id(); // Ambil ID user yang sedang login
        $votes = $report->votes ? json_decode($report->votes, true) : []; // Mendapatkan data votes yang sudah ada

        // Jika user sudah memberi vote, maka unvote (hapus vote)
        if (in_array($userId, $votes)) {
            // Hapus userId dari array votes untuk unvote
            $votes = array_filter($votes, function($vote) use ($userId) {
                return $vote != $userId;
            });

            // Menyimpan kembali votes yang telah diubah
            $report->votes = json_encode(array_values($votes)); // Reindex array untuk menghindari indeks yang hilang
            $report->save();

            return redirect()->back()->with('success', 'Anda telah menghapus vote Anda pada laporan ini.');
        }

        // Jika user belum memberi vote, beri vote
        $votes[] = $userId;

        // Simpan kembali array votes ke database
        $report->votes = json_encode($votes);
        $report->save();

        return redirect()->back()->with('success', 'Terima kasih telah memberi vote!');
    }


    public function showAllInformation()
    {
        $userId = Auth::id(); // Ambil ID user yang sedang login
        $reports = Report::where('user_id', $userId)->get(); // Memfilter laporan berdasarkan user_id
        return view('pages.guest.reports.all-information', compact('reports'));
    }
}
