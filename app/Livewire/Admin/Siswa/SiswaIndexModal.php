<?php

namespace App\Livewire\Admin\Siswa;

use App\Models\Siswa;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class SiswaIndexModal extends Component
{
    public $selectedSiswaId;
    public $modalId;

    #[Computed]
    public function siswa()
    {
        return Siswa::find($this->selectedSiswaId);
    }

    #[On('open-modal')]
    public function onOpenModal($modalId, $siswaId)
    {
        $this->selectedSiswaId = $siswaId;
    }

    public function delete(Siswa $siswa)
    {
        $this->reset('selectedSiswaId');
        if (($siswa->transaksi->count() == 0) && ($siswa->tabungan->count() == 0)) {
            if ($siswa->delete()) {
                $this->dispatch('refresh-siswa', 'success', 'siswa telah dihapus');
                return;
            }
        } else {
            $this->dispatch('refresh-siswa', 'danger', 'tidak dapat menghapus siswa yang masih memiliki transaksi');
            return;
        }
        $this->dispatch('refresh-siswa', 'danger', 'Err.., terjadi kesalahan');
    }

    public function render()
    {
        return view('livewire.admin.siswa.siswa-index-modal');
    }
}
