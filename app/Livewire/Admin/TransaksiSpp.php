<?php

namespace App\Livewire\Admin;

use App\Models\Siswa;
use App\Models\Tabungan;
use App\Models\Tagihan;
use App\Models\Transaksi;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class TransaksiSpp extends Component
{
    public $totalDiscount;
    public $hasDiscount = false;
    public $siswaId;
    public $tagihanId;
    public $totalPayment;
    public $paymentType = 'tunai';
    public $note;

    #[Computed]
    public function siswaDetail()
    {
        return Siswa::with('tagihanSiswa.tagihan')->whereId($this->siswaId)->first();
    }

    #[Computed]
    public function saldoSiswa()
    {
        $input = Tabungan::where('tipe', 'in')->where('siswa_id', $this->siswaId)->sum('jumlah');
        $output = Tabungan::where('tipe', 'out')->where('siswa_id', $this->siswaId)->sum('jumlah');
        $verify = Tabungan::where('siswa_id', $this->siswaId)->orderBy('created_at', 'desc')->first()->saldo ?? 0;

        $isValidSaldo = (($input - $output) == $verify);

        return collect([
            'saldo' => $isValidSaldo ? $input - $output : 0,
            'isValidSaldo' => $isValidSaldo
        ]);
    }

    #[Computed]
    public function tagihanKelas()
    {
        if (optional($this->siswaDetail)->kelas) {
            return Tagihan::where('kelas_id', $this->siswaDetail->kelas->id)->get();
        }
        return collect();
    }

    #[Computed]
    public function tagihan()
    {
        return Tagihan::find($this->tagihanId);
    }

    #[Computed]
    public function listTagihan()
    {
        $tagihanWajib = Tagihan::where('wajib_semua', true)->get();
        return collect()->merge($this->tagihanKelas)->merge($tagihanWajib)->when($this->siswaDetail, function ($collection) {
            foreach ($this->siswaDetail->tagihanSiswa as $tagihanSiswa) {
                $collection->push($tagihanSiswa->tagihan);
            }
            return $collection;
        });
    }

    #[Computed]
    public function listSiswa()
    {
        return Siswa::where('is_yatim', '0')->orderBy('created_at', 'desc')->get();
    }

    #[Computed]
    public function listTransaksi()
    {
        return Transaksi::orderBy('created_at', 'desc')->paginate(10);
    }

    #[Title('Transaksi SPP')]
    public function render()
    {
        return view('livewire.admin.transaksi-spp')->layout('layouts.app');
    }
}
