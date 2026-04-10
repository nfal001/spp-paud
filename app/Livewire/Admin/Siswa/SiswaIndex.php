<?php

namespace App\Livewire\Admin\Siswa;

use App\Http\Controllers\SiswaController;
use App\Models\Siswa;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\On;
use Livewire\Component;

class SiswaIndex extends Component
{
    public $search;
    public $isOrphan;

    #[On('refresh-siswa')]
    public function refresh()
    {
        // just to trigger refresh
    }

    public function export()
    {
        $this->redirectAction([SiswaController::class, 'export']);
    }

    #[Computed]
    public function siswa()
    {
        return Siswa::when($this->isOrphan, function ($q) {
            $q->where('is_yatim', true);
        })->when($this->search, function ($q) {
            $q->whereLike('nama', "%{$this->search}%");
        })->get();
    }

    public function promptDelete($id)
    {
        $this->dispatch('open-modal', modalId: 'deleteModal-siswa', siswaId: $id);
    }

    #[Layout('layouts.app')]
    #[Title('Daftar Siswa')]
    public function render()
    {
        return view('livewire.admin.siswa.siswa-index');
    }
}
