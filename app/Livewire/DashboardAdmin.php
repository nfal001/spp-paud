<?php

namespace App\Livewire;

use App\Http\Controllers\HomeController;
use App\Models\Kelas;
use App\Models\Keuangan;
use App\Models\Siswa;
use App\Models\Tagihan;
use App\Models\Transaksi;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class DashboardAdmin extends Component
{

    public $filterDate;
    public $jumlah = 0;

    public function cetakReport()
    {
        $this->redirectAction([HomeController::class, 'cetak'], [
            'date' => $this->filterDate
        ]);
    }

    public function exportReport()
    {
        $this->redirectAction([HomeController::class, 'export'], [
            'date' => $this->filterDate
        ]);
    }

    #[Computed]
    public function getListTransaksiHarian()
    {
        return Transaksi::orderBy('created_at', 'desc')
        ->whereDate('created_at', $this->filterDate)->get();
    }

    #[Computed]
    protected function transaksi($type = 'in', $tabunganId = null, $transaksiId = null, $notNullColumn = null)
    {
        return Keuangan::where('tipe', $type)
            ->when(
                $tabunganId,
                function ($q) use ($tabunganId) {
                    $q->where('tabungan_id', $tabunganId);
                }
            )
            ->when(
                $notNullColumn,
                function ($q) use ($notNullColumn) {
                    $q->whereNotNull($notNullColumn);
                }
            )->when($transaksiId, function ($q) use ($transaksiId) {
                $q->where('transaksi_id', $transaksiId);
            });
    }

    #[Computed]
    public function statistics()
    {
        $totalUangMasuk = $this->transaksi(type: 'in')->sum('jumlah');
        $totalUangKeluar = $this->transaksi(type: 'out')->sum('jumlah');
        $totalUang = $totalUangMasuk - $totalUangKeluar;

        return fluent([
            'totalSiswa' => Siswa::count(),
            'totalKelas' => Kelas::count(),
            'totalTagihan' => Tagihan::count(),
            'totalUang' => $totalUang,
            'totalUangMasuk' => $totalUangMasuk,
            'totalUangKeluar' => $totalUangKeluar,
            'totalUangTabungan' => $this->transaksi(type: 'in', notNullColumn: 'tabungan_id')->sum('jumlah') - $this->transaksi(type: 'out', notNullColumn: 'tabungan_id')->sum('jumlah'),
            'totalUangSPP' => $this->transaksi(type: 'in', notNullColumn: 'transaksi_id')->sum('jumlah') - $this->transaksi(type: 'out', notNullColumn: 'transaksi_id')->sum('jumlah'),
        ]);
    }

    public function mount()
    {
        $this->filterDate = now()->toDateString();
    }

    #[Title('Dashboard')]
    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.dashboard-admin');
    }
}
