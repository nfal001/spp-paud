<?php

namespace App\Livewire\Admin\Periode;

use App\Models\Periode;
use Livewire\Component;

class PeriodeUbah extends Component
{
    public Periode $periode;

    public $name;
    public $startDate;
    public $endDate;
    public $isActive = false;

    // TODO
    protected $rules = [
        'name' => 'required|max:255',
        'startDate' => 'required|date',
        'endDate' => 'required|date',
        'isActive' => 'nullable|boolean',
    ];

    public function updated($prop)
    {
        $this->validateOnly($prop);
    }

    public function submit()
    {
        $this->validate();

        $this->periode->fill([
            'nama' => $this->name,
            'tgl_mulai' => $this->startDate,
            'tgl_selesai' => $this->endDate,
            'is_active' => $this->isActive,
        ]);

        if ($this->isActive == null) {
            $this->periode->is_active = 0;
        }

        if ($this->periode->save()) {
            session()->flash('type', 'success');
            session()->flash('msg', 'Periode diubah');
            return redirect()->route('web.admin.periode.index');
        } else {
            session()->flash('type', 'danger');
            session()->flash('msg', 'Err.., Terjadi Kesalahan');
            return redirect()->route('web.admin.periode.index');
        }
    }

    public function mount()
    {

        $this->name = $this->periode->nama;
        $this->startDate = $this->periode->tgl_mulai;
        $this->endDate = $this->periode->tgl_selesai;
        $this->isActive = $this->periode->is_active;
    }

    public function render()
    {
        return view('livewire.admin.periode.periode-ubah')->layout('layouts.app');
    }
}
