<?php

namespace App\Livewire\Admin\Periode;

use App\Models\Periode;
use Livewire\Component;

class PeriodeTambah extends Component
{
    public $name;
    public $startDate;
    public $endDate;
    public $isActive = false;

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

        $periode = Periode::make([
            'nama' => $this->name,
            'tgl_mulai' => $this->startDate,
            'tgl_selesai' => $this->endDate,
            'is_active' => $this->isActive,
        ]);

        if ($this->isActive == null) {
            $periode->is_active = 0;
        }

        if ($periode->save()) {
            session()->flash('type', 'success');
            session()->flash('msg', 'Periode ditambah');
            return redirect()->route('web.admin.periode.index');
        } else {
            session()->flash('type', 'danger');
            session()->flash('msg', 'Err.., Terjadi Kesalahan');
            return redirect()->route('web.admin.periode.index');
        }
    }

    public function render()
    {
        return view('livewire.admin.periode.periode-tambah')->layout('layouts.app');
    }
}
