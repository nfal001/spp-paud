<div>
    <div class="page-header">
        <h1 class="page-title">
            @yield('page-name')
        </h1>
    </div>
    <div class="row gy-3">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Transaksi Non Siswa</h3>
                </div>
                @if (session()->has('msg'))
                    <div class="card-alert alert alert-{{ session()->get('type') }}" id="message"
                        style="border-radius: 0px !important">
                        @if (session()->get('type') == 'success')
                            <i class="fe fe-check mr-2" aria-hidden="true"></i>
                        @else
                            <i class="fe fe-alert-triangle mr-2" aria-hidden="true"></i>
                        @endif
                        {{ session()->get('msg') }}
                    </div>
                @endif
                <div class="card-body">
                    <form wire:submit='createTransaction'>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    {{ $error }}<br>
                                @endforeach
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-12">
                                @csrf
                                <div class="form-group">
                                    <label class="form-label">Keperluan</label>
                                    <div class="selectgroup w-100">
                                        <label class="selectgroup-item">
                                            <input wire:model.live='transactionType' type="radio"
                                                name="transactionType" value="in" class="selectgroup-input">
                                            <span class="selectgroup-button">Catat Pemasukan</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input wire:model.live='transactionType' type="radio"
                                                name="transactionType" value="out" class="selectgroup-input">
                                            <span class="selectgroup-button">Catat Pengeluaran</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group mt-2" id="form-jumlah" wire:show='transactionSelected'
                                    wire:loading.remove>
                                    <label class="form-label" for="transactionTotal">Jumlah</label>
                                    <input wire:model='transactionTotal' type="number" name="transactionTotal"
                                        id="jumlah" class="form-control" min='100' required>
                                </div>
                                <div class="form-group" id="form-keterangan" wire:show='transactionSelected'
                                    wire:loading.remove>
                                    <label class="form-label" for="transactionNote">Keterangan</label>
                                    <textarea wire:model='transactionNote' name="transactionNote" id="keterangan" rows="3" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2" wire:show='transactionSelected' wire:loading.remove>
                            <button id="submit" class="btn btn-primary ml-auto">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Mutasi Keuangan
                        <span class="spinner-border spinner-border-sm me-2" wire:loading
                            wire:target='filterTransactionType'></span>
                    </h3>
                    <div class="card-options">
                        <select id="select-type" wire:model.live='filterTransactionType'
                            class="form-select form-select-sm me-2" name="filter" required>
                            <option hidden>- Filter Tipe KD -</option>
                            <option value="all">Semua</option>
                            <option value="in">Uang Masuk</option>
                            <option value="out">Uang Keluar</option>
                        </select>`
                        <a wire:click='export' wire:loading.class='opacity-85' wire:target='export'
                            class="btn btn-primary btn-sm ml-2">Export</a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table card-table table-hover table-vcenter text-wrap">
                        <thead>
                            <tr>
                                <th class="w-1">No.</th>
                                <th>Tanggal</th>
                                <th>KD</th>
                                <th>Keterangan</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($this->keuangan as $index => $item)
                                <tr>
                                    <td><span class="text-muted">{{ $index + 1 }}</span></td>
                                    <td>{{ $item->created_at->format('d-m-Y') }}</td>
                                    <td>
                                        @if ($item->tipe == 'in')
                                            Uang Masuk
                                        @elseif($item->tipe == 'out')
                                            Uang Keluar
                                        @endif
                                    </td>
                                    <td style="max-width:150px;">{{ $item->keterangan }}</td>
                                    <td>IDR. {{ format_idr($item->jumlah) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <div class="d-flex">
                        <div class="ml-auto mb-0">
                            ?
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
