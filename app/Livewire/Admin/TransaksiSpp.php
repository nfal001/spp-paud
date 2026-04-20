<?php

namespace App\Livewire\Admin;

use App\Models\Keuangan;
use App\Models\Siswa;
use App\Models\Tabungan;
use App\Models\Tagihan;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class TransaksiSpp extends Component
{
    public $totalDiscount = 0;
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

    public function store()
    {
        $siswa = Siswa::findOrFail($this->siswaId);
        $tagihanModel = Tagihan::findOrFail($this->tagihanId);

        $jumlah = $tagihanModel->jumlah;
        $diskon = $this->hasDiscount ? ($this->totalDiscount ?? 0) : 0;
        $jumlah = $jumlah - $diskon;

        DB::beginTransaction();

        try {
            // membuat transaksi baru
            $transaksi = Transaksi::create([
                'siswa_id' => $siswa->id,
                'tagihan_id' => $tagihanModel->id,
                'diskon' => $diskon,
                'is_lunas' => 1,
                'keterangan' => ($this->paymentType == 'tabungan' ? 'dibayarkan melalui tabungan' : 'dibayarkan secara tunai')
                    . ', ' . $this->note,
            ]);

            // tambahkan transaksi ke keuangan
            $keuangan = Keuangan::orderBy('created_at', 'desc')->first();
            $total_kas = $keuangan ? $keuangan->total_kas + $jumlah : $jumlah;

            $keuangan = Keuangan::create([
                'transaksi_id' => $transaksi->id,
                'tipe' => 'in',
                'jumlah' => $jumlah,
                'total_kas' => $total_kas,
                'keterangan' => 'Pembayaran SPP oleh ' . $transaksi->siswa->nama
                    . ' pada tanggal ' . $transaksi->created_at
                    . ' dengan catatan : dibayarkan dengan ' . $this->paymentType
                    . ', ' . $this->note,
            ]);

            // jika pembayaran dilakukan melalui tabungan
            if ($this->paymentType == 'tabungan') {
                $tabungan = Tabungan::where('siswa_id', $siswa->id)
                    ->orderBy('created_at', 'desc')->first();

                $menabung = Tabungan::create([
                    'siswa_id' => $siswa->id,
                    'tipe' => 'out',
                    'jumlah' => $jumlah,
                    'saldo' => $tabungan->saldo - $jumlah,
                    'keperluan' => 'penarikan dilakukan untuk pembayaran spp melalui tabungan',
                ]);

                // tambahkan tabungan ke keuangan
                $keuanganLast = Keuangan::orderBy('created_at', 'desc')->first();
                $total_kas_tabungan = $keuanganLast
                    ? $keuanganLast->total_kas + $menabung->jumlah
                    : $menabung->jumlah;

                Keuangan::create([
                    'tabungan_id' => $menabung->id,
                    'tipe' => $menabung->tipe,
                    'jumlah' => $menabung->jumlah,
                    'total_kas' => $total_kas_tabungan,
                    'keterangan' => 'Transaksi tabungan oleh ' . $menabung->siswa->nama
                        . '(' . $menabung->siswa->kelas->nama . ')'
                        . ' melakukan pembayaran spp sebesar ' . $menabung->jumlah
                        . ' pada ' . $menabung->created_at
                        . ' dengan total tabungan ' . $menabung->saldo,
                ]);
            }

            DB::commit();

            // reset form
            $this->reset(['siswaId', 'tagihanId', 'totalDiscount', 'hasDiscount', 'paymentType', 'note']);

            session()->flash('type', 'success');
            session()->flash('msg', 'Transaksi berhasil dilakukan');
        } catch (\Exception $e) {
            DB::rollBack();

            session()->flash('type', 'danger');
            session()->flash('msg', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    #[Title('Transaksi SPP')]
    public function render()
    {
        return view('livewire.admin.transaksi-spp')->layout('layouts.app');
    }
}
