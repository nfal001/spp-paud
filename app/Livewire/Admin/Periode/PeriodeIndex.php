<?php

namespace App\Livewire\Admin\Periode;

use App\Models\Periode;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class PeriodeIndex extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $limit = 2;

    #[On('refresh-periode')]
    public function refresh()
    {
        unset($this->periode);
    }

    #[Computed]
    public function periode()
    {
        return Periode::orderBy('created_at', 'desc')->paginate($this->limit);
    }

    public function promptDelete($id)
    {
        $this->dispatch('open-modal', modalId: 'deleteModal-periode', periodeId: $id);
    }

    public function render()
    {
        return view('livewire.admin.periode.periode-index')->layout('layouts.app');
    }
}
