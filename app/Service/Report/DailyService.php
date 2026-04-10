<?php

namespace App\Service\Report;

use App\Exports\LaporanHarianExport;
use App\Models\Transaksi;
use Maatwebsite\Excel\Facades\Excel;

class DailyService
{
    public function cetak($date)
    {
        $dateFormat = \Carbon\Carbon::create($date)->format('Y-m-d');
        $transaksi = Transaksi::orderBy('siswa_id', 'desc')->whereDate('created_at', $dateFormat)->get();

        return view('dashboard.export', ['transaksi' => $transaksi, 'date' => $date, 'jumlah' => 0, 'print' => true]);
    }

    public function export($date)
    {
        $dateFormat = \Carbon\Carbon::create($date)->format('Y-m-d');
        return Excel::download(new LaporanHarianExport($dateFormat, $dateFormat), 'laporan-harian-' . $dateFormat . '.xlsx');

    }
}
