<?php

namespace App\Livewire\Admin\Siswa;

use App\Models\Kelas;
use App\Models\Siswa;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class Ubah extends Component
{
    public Siswa $siswa;
    public $fullname;
    public $birthDate;
    public $birthPlace;
    public $schoolClass;
    public $gender;
    public $address;
    public bool $isOrphan;
    public $parentName;
    public $parentJob;
    public $parentPhone;

    // TODO
    protected $rules = [
        'fullname' => 'nullable|string|max:512',
        'birthDate' => 'nullable|date', // date
        'birthPlace' => 'nullable|string',
        'schoolClass' => 'required|numeric', // exist `kelas` table
        'gender' => 'nullable', // enum: L,P
        'address' => 'nullable|string',
        'isOrphan' => 'nullable', // bool
        'parentName' => 'nullable|string',
        'parentJob' => 'nullable|string',
        'parentPhone' => 'nullable' // phone
    ];

    #[Computed]
    public function kelas()
    {
        return Kelas::all();
    }

    public function updated($prop)
    {
        $this->validateOnly($prop);
    }

    public function submit()
    {
        $this->validate();

        $this->siswa->fill([
            'nama' => $this->fullname,
            'tanggal_lahir' => $this->birthDate,
            'tempat_lahir' => $this->birthPlace,
            'kelas_id' => $this->schoolClass,
            'jenis_kelamin' => $this->gender,
            'alamat' => $this->address,
            'nama_wali' => $this->parentName,
            'pekerjaan_wali' => $this->parentJob,
            'telp_wali' => $this->parentPhone,
        ]);

        if ($this->isOrphan != null) {
            $this->siswa->is_yatim = 1;
        } else {
            $this->siswa->is_yatim = 0;
        }

        if ($this->siswa->save()) {
            $this->dispatch('refresh-siswa', 'success', 'siswa berhasil diubah');
            return redirect()->route('web.admin.siswa.index');
        }

        $this->addError('error', 'Err.., terjadi kesalahan');
    }

    public function mount()
    {
        $this->fullname = $this->siswa->nama;
        $this->birthDate = $this->siswa->tanggal_lahir;
        $this->birthPlace = $this->siswa->tempat_lahir;
        $this->schoolClass = $this->siswa->kelas_id;
        $this->gender = $this->siswa->jenis_kelamin;
        $this->address = $this->siswa->alamat;
        $this->isOrphan = $this->siswa->is_yatim;
        $this->parentName = $this->siswa->nama_wali;
        $this->parentJob = $this->siswa->pekerjaan_wali;
        $this->parentPhone = $this->siswa->telp_wali;
    }

    #[Title('Edit Siswa')]
    public function render()
    {
        return view('livewire.admin.siswa.ubah')->layout('layouts.app');
    }
}
