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
        dd($this->transactionType, $this->transactionTotal, $this->transactionNote);
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
