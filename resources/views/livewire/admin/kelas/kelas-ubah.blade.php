<div>
    {{-- Adapt --}}
    <div class="row">
        <div class="col-8">
            <form wire:submit="submit" class="card">
                <div class="card-header">
                    <h3 class="card-title">Tambah Kelas</h3>
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
                            <div class="form-group">
                                <label class="form-label">Periode</label>
                                <select class="form-control" name="periode_id" wire:model="periodeId">
                                    <option value="">-- Pilih Periode --</option>
                                    @foreach ($this->periode as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Nama</label>
                                <input type="text" class="form-control" name="nama" placeholder="Nama" wire:model='name'
                                    required>
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
