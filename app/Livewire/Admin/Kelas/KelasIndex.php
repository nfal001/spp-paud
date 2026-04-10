<?php

namespace App\Livewire\Admin\Kelas;

use App\Models\Kelas;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class KelasIndex extends Component
{
    use WithPagination;

    public $limit = 5;

    #[Computed]
    public function kelas()
    {
        return Kelas::orderBy('created_at', 'desc')->paginate($this->limit);
    }

    #[On('refresh-table')]
    public function refreshTable()
    {
        unset($this->kelas);
    }

    public function promptDelete($id)
    {
        $this->dispatch('open-modal', modalId: 'deleteModal-kelas', kelasId: $id);
    }

    #[Title('Daftar Kelas')]
    public function render()
    {
        return view('livewire.admin.kelas.kelas-index')->layout('layouts.app');
    }
}
