<div>
    <div class="page-header">
        <h1 class="page-title">
            Tagihan Baru
        </h1>
    </div>
    <div class="row">
        <div class="col-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tagihan Baru</h3>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                {{ $error }}<br>
                            @endforeach
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group mb-2">
                                <label class="form-label">Nama</label>
                                <input type="text" class="form-control" wire:model='nama' placeholder="Nama" required>
                                @error('nama')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <label class="form-label">Jumlah</label>
                                <input type="number" class="form-control" wire:model='jumlah' required>
                                @error('jumlah')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group mb-2">
                                <div class="form-label">Peserta</div>
                                <div class="custom-switches-stacked">
                                    <label class="custom-switch">
                                        <input type="radio" value="1" class="custom-switch-input"
                                            wire:model.live='peserta'>
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description">Wajib Semua Siswa</span>
                                    </label>
                                    <label class="custom-switch">
                                        <input type="radio" value="2" class="custom-switch-input"
                                            wire:model.live='peserta'>
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description">Hanya Kelas</span>
                                    </label>
                                    <label class="custom-switch">
                                        <input type="radio" value="3" class="custom-switch-input"
                                            wire:model.live='peserta'>
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description">Hanya Siswa</span>
                                    </label>
                                </div>
                            </div>

                            {{-- Kelas selector (peserta == 2) --}}
                            @if ($peserta == '2')
                                <div class="form-group mb-2">
                                    <label class="form-label">Kelas</label>
                                    <select class="form-control" wire:model='kelasId'>
                                        <option value="" hidden>[-- Pilih Kelas --]</option>
                                        @foreach ($this->listKelas as $item)
                                            <option value="{{ $item->id }}">
                                                {{ $item->nama }}
                                                {{ isset($item->periode) ? ' - ' . $item->periode->nama : '' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('kelasId')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            @endif

                            {{-- Siswa multi-select checkboxes (peserta == 3) --}}
                            @if ($peserta == '3')
                                <div class="form-group mb-2">
                                    <label class="form-label">Siswa</label>
                                    @error('selectedSiswaIds')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                    <div class="border rounded p-2" style="max-height: 250px; overflow-y: auto;">
                                        @foreach ($this->listSiswa as $item)
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input"
                                                    value="{{ $item->id }}" wire:model='selectedSiswaIds'>
                                                <span class="custom-control-label">
                                                    {{ $item->nama }} - {{ $item->kelas->nama }}
                                                    {{ isset($item->kelas->periode) ? '(' . $item->kelas->periode->nama . ')' : '' }}
                                                </span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <div class="d-flex">
                        <a wire:navigate href="{{ route('web.admin.tagihan.index') }}" class="btn btn-link">Batal</a>
                        <button wire:click='store' wire:loading.attr='disabled' wire:target='store'
                            class="btn btn-primary ml-auto">
                            <span class="spinner-border spinner-border-sm me-1" wire:loading
                                wire:target='store'></span>
                            Simpan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
