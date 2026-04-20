<?php

namespace App\Livewire\Admin\Kelas;

use App\Models\Kelas;
use App\Models\Periode;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;

class KelasTambah extends Component
{

    public $periodeId;
    public $name;

    protected $rules = [
        'periodeId' => 'required',
        'name' => 'required',
    ];

    #[Computed]
    public function periode()
    {
        return Periode::all();
    }

    public function updated($prop)
    {
        $this->validateOnly($prop);
    }

    public function submit()
    {
        $this->validate();

        $kelas = Kelas::make([
            'periode_id' => $this->periodeId,
            'nama' => $this->name,
        ]);

        if ($kelas->save()) {
            session()->flash('type', 'success');
            session()->flash('msg', 'Kelas berhasil ditambahkan');
        } else {
            session()->flash('type', 'danger');
            session()->flash('msg', 'Err.., Terjadi Kesalahan');
        }

        $this->redirectRoute('web.admin.kelas.index', navigate: true);
    }

    #[Title('Tambah Kelas')]
    public function render()
    {
        return view('livewire.admin.kelas.kelas-tambah')->layout('layouts.app');
    }
}
