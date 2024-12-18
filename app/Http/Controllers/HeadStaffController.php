<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class HeadStaffController extends Controller
{
    public function index()
    {
        $staffs = User::where('role', 'STAFF')->get();
        return view('pages.headstaff.dashboard', compact('staffs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'STAFF',
        ]);

        return redirect()->route('headstaff.dashboard')->with('success', 'Staff berhasil ditambahkan!');
    }

    public function reset($id)
    {
        

        User::where('id', $id)->update([
            'password' => Hash::make('password'),
        ]);
    }

    public function delete($id)
    {
        User::where('id', $id)->delete();
        return redirect()->route('headstaff.dashboard')->with('success', 'Staff berhasil dihapus!');
    }
}
