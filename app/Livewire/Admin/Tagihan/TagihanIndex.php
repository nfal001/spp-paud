<?php

namespace App\Livewire\Admin\Tagihan;

use App\Models\Tagihan;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class TagihanIndex extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $limit = 5;

    #[Computed]
    public function tagihan()
    {
        return Tagihan::orderBy('created_at', 'desc')->paginate($this->limit);
    }

    public function promptDelete($id)
    {
        $this->dispatch('open-modal', modalId: 'deleteModal-tagihan', tagihanId: $id);
    }

    #[Title('Daftar Tagihan')]
    public function render()
    {
        return view('livewire.admin.tagihan.tagihan-index')->layout('layouts.app');
    }
}
