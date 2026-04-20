<?php

namespace App\Livewire\Admin\Tagihan;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Tagihan;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class TagihanUbah extends Component
{
    public $tagihanId;

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

    public function mount($tagihanId)
    {
        $tagihan = Tagihan::findOrFail($tagihanId);

        $this->nama = $tagihan->nama;
        $this->jumlah = $tagihan->jumlah;

        // determine peserta type from existing data
        if ($tagihan->wajib_semua == 1) {
            $this->peserta = '1';
        } elseif ($tagihan->kelas_id != null) {
            $this->peserta = '2';
            $this->kelasId = $tagihan->kelas_id;
        } else {
            $this->peserta = '3';
            $this->selectedSiswaIds = $tagihan->siswa->pluck('id')->toArray();
        }
    }

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

    public function update()
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

        $tagihan = Tagihan::findOrFail($this->tagihanId);

        $tagihan->fill([
            'nama' => $this->nama,
            'jumlah' => $this->jumlah,
        ]);

        // remove all related
        $tagihan->siswa()->detach();
        $tagihan->kelas_id = null;
        $tagihan->wajib_semua = null;

        switch ($this->peserta) {
            case '1': // semua
                $tagihan->wajib_semua = 1;
                break;
            case '2': // hanya kelas
                $tagihan->kelas_id = $this->kelasId;
                break;
            case '3': // hanya siswa
                $tagihan->save();
                foreach ($this->selectedSiswaIds as $siswaId) {
                    $tagihan->siswa()->save(Siswa::find($siswaId));
                }
                break;
        }

        if ($tagihan->save()) {
            session()->flash('type', 'success');
            session()->flash('msg', 'Item Tagihan diubah');
        } else {
            session()->flash('type', 'danger');
            session()->flash('msg', 'Err.., Terjadi Kesalahan');
        }

        $this->redirectRoute('web.admin.tagihan.index');
    }

    #[Layout('layouts.app')]
    #[Title('Ubah Tagihan')]
    public function render()
    {
        return view('livewire.admin.tagihan.tagihan-ubah');
    }
}
