<?php

namespace App\Livewire\Admin\Siswa;

use App\Models\Kelas;
use App\Models\Siswa;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class Tambah extends Component
{
    public $fullname;
    public $birthDate;
    public $birthPlace;
    public $schoolClass;
    public $gender;
    public $address;
    public $isOrphan;
    public $parentName;
    public $parentJob;
    public $parentPhone;

    // TODO
    protected $rules = [
        'fullname' => 'nullable|string|max:512',
        'birthDate' => 'nullable|date', // date
        'birthPlace' => 'nullable|string',
        'schoolClass' => 'required|string', // exist `kelas` table
        'gender' => 'nullable|in:L,P', // enum: L,P
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

        $siswa = Siswa::make([
            'kelas_id' => $this->schoolClass,
            'nama' => $this->fullname,
            'tempat_lahir' => $this->birthPlace,
            'tanggal_lahir' => $this->birthDate,
            'jenis_kelamin' => $this->gender,
            'alamat' => $this->address,
            'nama_wali' => $this->parentName,
            'telp_wali' => $this->parentPhone,
        ]);

        if ($this->isOrphan != null) {
            $siswa->is_yatim = 1;
        } else {
            $siswa->is_yatim = 0;
        }

        if ($siswa->save()) {
            $this->redirectRoute('web.admin.siswa.index', [
                'type' => 'success',
                'msg' => 'Siswa ditambahkan'
            ]);
        } else {
            $this->redirectRoute('web.admin.siswa.index', [
                'type' => 'danger',
                'msg' => 'Err.., Terjadi Kesalahan'
            ]);
        }
    }

    #[Layout('layouts.app')]
    #[Title('Tambah Siswa')]
    public function render()
    {
        return view('livewire.admin.siswa.tambah');
    }
}
