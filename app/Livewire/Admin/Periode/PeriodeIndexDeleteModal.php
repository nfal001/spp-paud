<?php

namespace App\Livewire\Admin\Periode;

use App\Models\Periode;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class PeriodeIndexDeleteModal extends Component
{
    public $selectedPeriodeId;
    public $modalId;

    #[Computed]
    public function periode()
    {
        return Periode::find($this->selectedPeriodeId);
    }

    #[On('open-modal')]
    public function onOpenModal($modalId, $periodeId)
    {
        $this->selectedPeriodeId = $periodeId;
    }

    public function delete(Periode $periode)
    {
        $this->reset('selectedPeriodeId');
        if ($periode->kelas->count() != 0) {
            session()->flash('type', 'danger');
            session()->flash('msg', 'Tidak dapat menghapus periode yang memiliki kelas');
            return redirect()->route('web.admin.periode.index');
        }
        if ($periode->delete()) {
            session()->flash('type', 'success');
            session()->flash('msg', 'Periode dihapus');
            return redirect()->route('web.admin.periode.index');
        } else {
            session()->flash('type', 'danger');
            session()->flash('msg', 'Err.., Terjadi Kesalahan');
            return redirect()->route('web.admin.periode.index');
        }
    }

    public function render()
    {
        return view('livewire.admin.periode.periode-index-delete-modal');
    }
}
