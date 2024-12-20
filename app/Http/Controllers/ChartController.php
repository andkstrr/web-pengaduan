<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;

class ChartController extends Controller
{
    public function index()
    {
        $data = Report::all();
        $value1 = $data->count();
        $value2 = 0;

        return view('pages.headstaff.dashboard', compact('value1', 'value2'));
    }
}
