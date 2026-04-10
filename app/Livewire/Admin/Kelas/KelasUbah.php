<?php

namespace App\Livewire\Admin\Kelas;

use App\Models\Kelas;
use App\Models\Periode;
use Livewire\Attributes\Computed;
use Livewire\Component;

class KelasUbah extends Component
{
    public Kelas $kelas;
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

        $this->kelas->fill([
            'periode_id' => $this->periodeId,
            'nama' => $this->name,
        ]);

        if ($this->kelas->save()) {
            session()->flash('type', 'success');
            session()->flash('msg', 'Kelas berhasil diubah');
            return redirect()->route('web.admin.kelas.index');
        } else {
            session()->flash('type', 'danger');
            session()->flash('msg', 'Err.., Terjadi Kesalahan');
            return redirect()->route('web.admin.kelas.index');
        }
    }

    public function mount()
    {
        $this->periodeId = $this->kelas->periode_id;
        $this->name = $this->kelas->nama;
    }

    public function render()
    {
        return view('livewire.admin.kelas.kelas-ubah')->layout('layouts.app');
    }
}
