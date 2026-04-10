<div>
    <div class="row">
        <div class="col-8">
            <form class="card" wire:submit='submit'>
                <div class="card-header">
                    <h3 class="card-title">Ubah Siswa</h3>
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
                                <label class="form-label">Kelas</label>
                                <select wire:model.live='schoolClass' id="select-beast" class="form-control custom-select"
                                    name="kelas_id" required>
                                    <option hidden>--- select class ---</option>
                                    @foreach ($this->kelas as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->nama }} -
                                            {{ optional($item->periode)->nama ?? '' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <label class="form-label">Nama</label>
                                <input wire:model.live='fullname' type="text" class="form-control" name="nama"
                                    placeholder="Nama Lengkap" required>
                            </div>
                            <div class="form-group mb-2">
                                <label class="form-label">Tempat, Tanggal Lahir</label>
                                <div class="row gutters-xs">
                                    <div class="col-6">
                                        <input wire:model.live='birthPlace' type="text" class="form-control"
                                            name="tempat_lahir" placeholder="Tempat Lahir">
                                    </div>
                                    <div class="col-6">
                                        <input wire:model.live='birthDate' type="date" class="form-control"
                                            name="tanggal_lahir" placeholder="Tanggal Lahir">
                                    </div>
                                </div>

                            </div>
                            <div class="form-group mb-2">
                                <label class="form-label">Jenis Kelamin</label>
                                <select wire:model.live='gender' id="select-beast" class="form-control custom-select"
                                    name="jenis_kelamin" required>
                                    <option hidden>
                                        --- select gender ---</option>
                                    <option value="L">
                                        Laki - Laki</option>
                                    <option value="P">
                                        Perempuan</option>
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <label class="form-label">Alamat</label>
                                <textarea wire:model.live='address' class="form-control" name="alamat"></textarea>
                            </div>
                            <div class="form-group mb-2">
                                <label class="form-label">Nama Wali</label>
                                <input wire:model.live='parentName' type="text" class="form-control" name="nama_wali"
                                    placeholder="Nama Lengkap">
                            </div>
                            <div class="form-group mb-2">
                                <label class="form-label">Telp. Wali</label>
                                <input wire:model.live='parentPhone' type="text" class="form-control" name="telp_wali"
                                    placeholder="Nomor Telp. Lengkap">
                            </div>
                            <div class="form-group mb-2">
                                <label class="form-label">Pekerjaan Wali</label>
                                <input wire:model.live='parentJob' type="text" class="form-control" name="pekerjaan_wali"
                                    placeholder="Pekerjaan Wali">
                            </div>
                            <div class="form-group mb-2">
                                <div class="form-label">Status</div>
                                <label class="custom-switch">
                                    <input wire:model.live='isOrphan' type="checkbox" name="is_yatim" value="1"
                                        class="custom-switch-input">
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description">Anak Yatim Piatu</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <div class="d-flex gap-2">
                        <a href="{{ url()->previous() }}" class="btn btn-link">Batal</a>
                        <button type="submit" class="btn btn-primary ml-auto">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
