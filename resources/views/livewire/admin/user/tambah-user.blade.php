<div>
    <div class="row">
        <div class="col-8">
            <form class="card" wire:submit='submit'>
                <div class="card-header">
                    <h3 class="card-title">Tambah User</h3>
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
                                <input type="text" class="form-control" name="name" placeholder="Nama"
                                    wire:model.live="name" required>
                            </div>
                            <div class="form-group mb-2">
                                <label class="form-label">Email</label>
                                <input type="text" class="form-control" name="email" placeholder="Email"
                                    wire:model.live="email" required>
                            </div>
                            <div class="form-group mb-2">
                                <label class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" wire:model.live='password'
                                    required>
                            </div>
                            <div class="form-group mb-2">
                                <label class="form-label">Konfirmasi Password</label>
                                <input type="password" class="form-control" name="password_confirmation"
                                    wire:model.live='passwordConfirmation' required>
                            </div>
                            <div class="form-group mb-2">
                                <label class="form-label">Status</label>
                                <select id="select-beast" class="form-control custom-select" wire:model.live='status'
                                    name="role">
                                    <option value="">Pilih Status</option>
                                    @foreach (['SuperAdmin', 'Admin', 'Bendahara'] as $role)
                                        <option value="{{ $role }}">{{ $role }}</option>
                                    @endforeach
                                </select>
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
