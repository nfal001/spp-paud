<?php

namespace App\Livewire\Admin\Siswa;

use App\Models\Siswa;
use Livewire\Attributes\Computed;
use Livewire\Component;

class SiswaDetail extends Component
{
    public $siswaId;

    #[Computed]
    public function siswa()
    {
        // TODO: with Tabungan and Tagihan SPP
        return Siswa::find($this->siswaId);
    }

    public function cetakTabungan()
    {
        // TODO: as is
    }
    public function cetakTagihan()
    {
        // TODO: as is
    }
    public function exportTabungan()
    {
        // TODO: as is
    }
    public function exportTagihan()
    {
        // TODO: as is
    }

    public function render()
    {
        return view('livewire.admin.siswa.siswa-detail');
    }
}
