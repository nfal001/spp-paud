<div>
    <div class="row">
        <div class="col-8">
            <form wire:submit='submit' class="card">
                <div class="card-header">
                    <h3 class="card-title">Update Data Pengguna</h3>
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
                            <div class="row gy-2">
                                <div class="form-group">
                                    <label class="form-label">Nama</label>
                                    <input type="text" class="form-control" wire:model="name" placeholder="nama"
                                        value="{{ isset($user) ? $user->name : old('name') }}" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Email</label>
                                    <input type="text" class="form-control" wire:model="email"
                                        placeholder="email@example.com"
                                        value="{{ isset($user) ? $user->email : old('email') }}" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Password</label>
                                    <input type="password" class="form-control" wire:model="password" value=""
                                        {{ isset($user) ? '' : 'required' }}>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Konfirmasi Password</label>
                                    <input type="password" class="form-control" wire:model="passwordConfirmation"
                                        value="" {{ isset($user) ? '' : 'required' }}>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Status</label>
                                    <select id="select-beast" class="form-control custom-select" wire:model="role">
                                        <option value="SuperAdmin">Super Admin</option>
                                        <option value="Admin">Admin</option>
                                        <option value="Bendahara">Bendahara</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <div class="d-flex gap-2">
                        <a href="{{ route('web.admin.user.index') }}" wire:navigate class="btn btn-link">Batal</a>
                        <button type="submit" class="btn btn-primary ml-auto">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
