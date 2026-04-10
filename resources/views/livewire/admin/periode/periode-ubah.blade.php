<div>
    <div class="row">
        <div class="col-8">
            <form wire:submit='submit' class="card">
                <div class="card-header">
                    <h3 class="card-title">Ubah periode</h3>
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
                                <input type="text" class="form-control" name="nama" placeholder="Nama" wire:model='name' required>
                            </div>
                            <div class="form-group mb-2">
                                <label class="form-label">Tanggal Mulai s/d Selesai</label>
                                <div class="row gutters-xs">
                                    <div class="col-6">
                                        <input type="date" class="form-control" name="tgl_mulai" placeholder="Tanggal Mulai" wire:model.live='startDate' required>
                                    </div>
                                    <div class="col-6">
                                        <input type="date" class="form-control" name="tgl_selesai" placeholder="Tanggal Selesai" wire:model.live='endDate' required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-2">
                                <div class="form-label">Status</div>
                                <label class="custom-switch">
                                    <input type="checkbox" name="is_active" class="custom-switch-input" wire:model.live='isActive'>
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description">Aktif</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <div class="d-flex">
                        <a href="{{ url()->previous() }}" class="btn btn-link">Batal</a>
                        <button type="submit" class="btn btn-primary ml-auto">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
