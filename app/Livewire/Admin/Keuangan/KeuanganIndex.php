<?php

namespace App\Livewire\Admin\Keuangan;

use App\Http\Controllers\KeuanganController;
use App\Models\Keuangan;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class KeuanganIndex extends Component
{
    public $transactionType;
    public $transactionTotal;
    public $transactionNote;
    public bool $transactionSelected = false;

    public $filterTransactionType;

    protected $rules = [
        'filterTransactionType' => 'nullable' // enum, in out all
    ];

    public function createTransaction()
    {
        $this->validate([
            'transactionType' => 'required|in:in,out',
            'transactionTotal' => 'required|numeric|min:1',
            'transactionNote' => 'nullable',
        ]);

        $keuanganTerakhir = Keuangan::orderBy('created_at', 'desc')->first();

        $simpan = Keuangan::make([
            'tipe' => $this->transactionType,
            'jumlah' => $this->transactionTotal,
            'keterangan' => $this->transactionNote,
        ]);

        if ($keuanganTerakhir != null) {
            if ($this->transactionType == 'in') {
                $simpan->total_kas = $keuanganTerakhir->total_kas + $this->transactionTotal;
            } else {
                $simpan->total_kas = $keuanganTerakhir->total_kas - $this->transactionTotal;
            }
        } else {
            $simpan->total_kas = $this->transactionTotal;
        }

        if ($simpan->save()) {
            $this->reset(['transactionType', 'transactionTotal', 'transactionNote', 'transactionSelected']);

            session()->flash('type', 'success');
            session()->flash('msg', 'Pencatatan Keuangan dibuat');
        } else {
            session()->flash('type', 'danger');
            session()->flash('msg', 'Terjadi Kesalahan');
        }
    }

    #[Computed]
    public function keuangan()
    {
        return Keuangan::when($this->filterTransactionType, function ($q) {
            if ($this->filterTransactionType != 'all') {
                $q->where('tipe', $this->filterTransactionType);
            }
        })->orderBy('created_at', 'desc')->paginate(10);
    }

    public function export()
    {
        $this->redirectAction([KeuanganController::class, 'export']);
    }

    public function updatedTransactionType($data)
    {
        $this->transactionSelected = true;
    }

    #[Layout('layouts.app')]
    #[Title('Keuangan')]
    public function render()
    {
        return view('livewire.admin.keuangan.keuangan-index');
    }
}

