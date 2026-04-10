<?php

namespace App\Livewire\Admin\Tabungan;

use App\Models\Siswa;
use App\Models\Tabungan;
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
        dd($this);
    }

    #[Layout('layouts.app')]
    #[Title('List Tabungan')]
    public function render()
    {
        return view('livewire.admin.tabungan.tabungan-index');
    }
}
