<?php

namespace App\Livewire\Admin\Tagihan;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Tagihan;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class TagihanTambah extends Component
{
    public $nama;
    public $jumlah;
    public $peserta = '1'; // 1=semua, 2=kelas, 3=siswa
    public $kelasId;
    public $selectedSiswaIds = [];

    protected $rules = [
        'nama' => 'required|max:255',
        'jumlah' => 'required|numeric',
        'peserta' => 'required|in:1,2,3',
    ];

    #[Computed]
    public function listKelas()
    {
        return Kelas::all();
    }

    #[Computed]
    public function listSiswa()
    {
        return Siswa::where('is_yatim', '!=', '1')->orderBy('created_at', 'desc')->get();
    }

    public function updatedPeserta()
    {
        $this->reset('kelasId', 'selectedSiswaIds');
    }

    public function store()
    {
        $this->validate();

        // extra validation per peserta type
        if ($this->peserta == '2' && empty($this->kelasId)) {
            $this->addError('kelasId', 'Kelas wajib dipilih');
            return;
        }
        if ($this->peserta == '3' && empty($this->selectedSiswaIds)) {
            $this->addError('selectedSiswaIds', 'Pilih minimal satu siswa');
            return;
        }

        $tagihan = Tagihan::make([
            'nama' => $this->nama,
            'jumlah' => $this->jumlah,
        ]);

        switch ($this->peserta) {
            case '1': // semua
                $tagihan->wajib_semua = 1;
                $tagihan->save();
                break;
            case '2': // hanya kelas
                $tagihan->kelas_id = $this->kelasId;
                $tagihan->save();
                break;
            case '3': // hanya siswa
                $tagihan->save();
                foreach ($this->selectedSiswaIds as $siswaId) {
                    $tagihan->siswa()->save(Siswa::find($siswaId));
                }
                break;
        }

        session()->flash('type', 'success');
        session()->flash('msg', 'Item Tagihan ditambahkan');

        $this->redirectRoute('web.admin.tagihan.index');
    }

    #[Layout('layouts.app')]
    #[Title('Tambah Tagihan')]
    public function render()
    {
        return view('livewire.admin.tagihan.tagihan-tambah');
    }
}
