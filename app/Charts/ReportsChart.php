<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\Report;

class ReportsChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\BarChart
    {
        $pengaduanCount = Report::count();
        $tanggapanCount = 0;

        return $this->chart->barChart()
            ->setTitle('Laporan Pengaduan Masyarakat')
            ->setSubtitle('dan Tanggapan Pengaduan')
            ->addData('Pengaduan', [[$pengaduanCount]])
            ->addData('Tanggapan', [[$pengaduanCount]]);
    }
}
