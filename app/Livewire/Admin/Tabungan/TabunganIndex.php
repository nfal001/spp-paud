<?php

namespace App\Livewire\Admin\Tabungan;

use App\Models\Keuangan;
use App\Models\Siswa;
use App\Models\Tabungan;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class TabunganIndex extends Component
{
    public $selectedSiswaId;
    public $transactionType;

    public $transactionTotalAmount;
    public $transactionReason;

    #[Computed]
    public function siswa()
    {
        return Siswa::orderBy('created_at', 'desc')->get();
    }

    #[Computed]
    public function siswaSaldo()
    {
        $input = Tabungan::where('tipe', 'in')->where('siswa_id', $this->selectedSiswaId)->sum('jumlah');
        $output = Tabungan::where('tipe', 'out')->where('siswa_id', $this->selectedSiswaId)->sum('jumlah');
        $verify = Tabungan::where('siswa_id', $this->selectedSiswaId)->orderBy('created_at', 'desc')->first()->saldo ?? 0;
        $isValidSaldo = (($input - $output) == $verify);
        return collect([
            'saldo' => $isValidSaldo ? $input - $output : 0,
            'isValidSaldo' => $isValidSaldo
        ]);
    }


    #[Computed]
    public function tabungan()
    {
        return Tabungan::orderBy('created_at', 'desc')->paginate(10);
    }

    public function updatedTransactionType()
    {
        $this->reset('selectedSiswaId');
    }

    public function updatedSelectedSiswaId()
    {
        $this->reset('transactionTotalAmount', 'transactionReason');
    }

    public function createTransaction()
    {
        $siswa = Siswa::findOrFail($this->selectedSiswaId);
        $jumlah = preg_replace("/[,.]/", "", $this->transactionTotalAmount);
        $tipe = $this->transactionType; // 'in' or 'out'

        // validasi jumlah
        if ($jumlah <= 0) {
            session()->flash('type', 'danger');
            session()->flash('msg', 'Jumlah harus lebih dari 0');
            return;
        }

        // validasi penarikan
        if ($tipe == 'out') {
            $saldo = $this->siswaSaldo['saldo'];
            if ($saldo <= 0 || $saldo < $jumlah) {
                session()->flash('type', 'danger');
                session()->flash('msg', 'Tidak dapat melakukan penarikan, saldo ' . $saldo . ' dengan jumlah ' . $jumlah);
                return;
            }
        }

        DB::beginTransaction();

        try {
            $tabunganTerakhir = Tabungan::where('siswa_id', $siswa->id)
                ->orderBy('created_at', 'desc')->first();

            if ($tabunganTerakhir != null) {
                if ($tipe == 'in') {
                    $saldoBaru = $jumlah + $tabunganTerakhir->saldo;
                } else {
                    $saldoBaru = $tabunganTerakhir->saldo - $jumlah;
                }

                if ($saldoBaru < 0) {
                    DB::rollBack();
                    session()->flash('type', 'danger');
                    session()->flash('msg', 'Transaksi gagal, saldo tidak mencukupi');
                    return;
                }

                $menabung = Tabungan::create([
                    'siswa_id' => $siswa->id,
                    'tipe' => $tipe,
                    'jumlah' => $jumlah,
                    'saldo' => $saldoBaru,
                    'keperluan' => $this->transactionReason,
                ]);
            } else {
                // first-time deposit
                $menabung = Tabungan::create([
                    'siswa_id' => $siswa->id,
                    'tipe' => $tipe,
                    'jumlah' => $jumlah,
                    'saldo' => $jumlah,
                    'keperluan' => $this->transactionReason,
                ]);
            }

            // tambahkan tabungan ke keuangan
            $keuanganTerakhir = Keuangan::orderBy('created_at', 'desc')->first();

            if ($keuanganTerakhir != null) {
                if ($menabung->tipe == 'in') {
                    $totalKas = $keuanganTerakhir->total_kas + $menabung->jumlah;
                } else {
                    $totalKas = $keuanganTerakhir->total_kas - $menabung->jumlah;
                }
            } else {
                $totalKas = $menabung->jumlah;
            }

            Keuangan::create([
                'tabungan_id' => $menabung->id,
                'tipe' => $menabung->tipe,
                'jumlah' => $menabung->jumlah,
                'total_kas' => $totalKas,
                'keterangan' => 'Transaksi tabungan oleh ' . $menabung->siswa->nama
                    . '(' . $menabung->siswa->kelas->nama . ')'
                    . ($tipe == 'in' ? ' menabung' : ' melakukan penarikan tabungan')
                    . ' sebesar ' . $menabung->jumlah
                    . ' pada ' . $menabung->created_at
                    . ' dengan total tabungan ' . $menabung->saldo
                    . (isset($menabung->keperluan) ? ' dengan catatan: ' . $menabung->keperluan : ''),
            ]);

            DB::commit();

            // reset form
            $this->reset(['selectedSiswaId', 'transactionType', 'transactionTotalAmount', 'transactionReason']);

            session()->flash('type', 'success');
            session()->flash('msg', 'Berhasil melakukan transaksi');
        } catch (\Exception $e) {
            DB::rollBack();

            session()->flash('type', 'danger');
            session()->flash('msg', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    #[Layout('layouts.app')]
    #[Title('List Tabungan')]
    public function render()
    {
        return view('livewire.admin.tabungan.tabungan-index');
    }
}

