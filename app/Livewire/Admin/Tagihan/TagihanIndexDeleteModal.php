<?php

namespace App\Livewire\Admin\Tagihan;

use App\Models\Tagihan;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class TagihanIndexDeleteModal extends Component
{
    public $selectedTagihanId;
    public $modalId;

    #[Computed]
    public function tagihan()
    {
        return Tagihan::find($this->selectedTagihanId);
    }

    #[On('open-modal')]
    public function onOpenModal($modalId, $tagihanId)
    {
        $this->selectedTagihanId = $tagihanId;
    }

    public function delete(Tagihan $tagihan)
    {
        $this->reset('selectedTagihanId');

        if ($tagihan->transaksi->count() != 0) {
            session()->flash('type', 'danger');
            session()->flash('msg', 'tidak dapat menghapus tagihan yang masih memiliki transaksi');
            return redirect()->route('web.admin.tagihan.index');
        }
        $tagihan->siswa()->detach();
        if ($tagihan->delete()) {
            session()->flash('type', 'success');
            session()->flash('msg', 'tagihan telah dihapus');
            return redirect()->route('web.admin.tagihan.index');
        }
    }

    public function render()
    {
        return view('livewire.admin.tagihan.tagihan-index-delete-modal');
    }
}
