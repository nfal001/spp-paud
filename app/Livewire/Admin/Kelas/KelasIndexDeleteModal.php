<?php

namespace App\Livewire\Admin\Kelas;

use App\Models\Kelas;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class KelasIndexDeleteModal extends Component
{
    public $selectedKelasId;
    public $modalId;

    #[Computed]
    public function kelas()
    {
        return Kelas::find($this->selectedKelasId);
    }

    #[On('open-modal')]
    public function onOpenModal($modalId, $kelasId)
    {
        $this->selectedKelasId = $kelasId;
    }

    public function delete()
    {
        $kelas = Kelas::find($this->selectedKelasId);

        $this->reset('selectedKelasId');
        if ($kelas->siswa->count() != 0) {
            session()->flash('type', 'danger');
            session()->flash('msg', 'Tidak dapat menghapus kelas yang memiliki siswa');
            return redirect()->route('web.admin.kelas.index');
        }
        if ($kelas->delete()) {
            session()->flash('type', 'success');
            session()->flash('msg', 'Kelas dihapus');
            return redirect()->route('web.admin.kelas.index');
        } else {
            session()->flash('type', 'danger');
            session()->flash('msg', 'Err.., Terjadi Kesalahan');
            return redirect()->route('web.admin.kelas.index');
        }
    }

    public function render()
    {
        return view('livewire.admin.kelas.kelas-index-delete-modal');
    }
}
