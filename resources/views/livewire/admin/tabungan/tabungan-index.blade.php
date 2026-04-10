<div>
    <div class="page-header">
        <h1 class="page-title">
            @yield('page-name')
        </h1>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Transaksi</h3>
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
                    {{-- <form action="{{ route('tabungan.store') }}" method="post"> --}}
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
                                <label class="form-label">Keperluan</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="keperluan" value="in"
                                            wire:model.live='transactionType' class="selectgroup-input">
                                        <span class="selectgroup-button">Menabung</span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="keperluan" value="out"
                                            wire:model.live='transactionType' class="selectgroup-input">
                                        <span class="selectgroup-button">Penarikan</span>
                                    </label>
                                </div>
                            </div>
                            @if ($transactionType)
                                <div class="form-group gap-2 mb-2" style="" id="form-siswa" wire:loading.remove
                                    wire:target='transactionType'>
                                    <label for="siswa_id" class="form-label">Siswa</label>
                                    <select id="siswa" class="form-control" wire:model.live='selectedSiswaId'
                                        name="siswa_id">
                                        <option hidden>[-- Pilih Siswa --]</option>
                                        @foreach ($this->siswa as $item)
                                            <option value="{{ $item->id }}">
                                                {{ $item->nama . ' - ' . $item->kelas->nama . ' - ' }} </option>
                                        @endforeach
                                    </select><br>
                                    <div wire:loading wire:target='selectedSiswaId'>Memuat Data Siswa...</div>
                                    @if ($this->selectedSiswaId)
                                        <span wire:loading.remove wire:target='selectedSiswaId'>
                                            Saldo: IDR. <span id="saldo">{{ $this->siswaSaldo['saldo'] }}</span>
                                        </span>
                                    @endif
                                </div>
                            @endif
                            @if ($this->selectedSiswaId)
                                <div class="form-group mb-2" wire:loading.remove
                                    wire:target='transactionType,selectedSiswaId' id="form-jumlah">
                                    <label class="form-label">Jumlah</label>
                                    <input wire:model='transactionTotalAmount' type="number" name="jumlah" id="jumlah" class="form-control"
                                        min='100' placeholder="masukan jumlah tanpa tanda titik atau koma">
                                </div>
                                <div class="form-group mb-2" wire:loading.remove
                                    wire:target='transactionType,selectedSiswaId' id="form-keterangan">
                                    <label class="form-label">Keterangan</label>
                                    <textarea wire:model='transactionReason' name="keperluan" id="keterangan" rows="3" class="form-control"></textarea>
                                </div>
                            @endif
                        </div>
                    </div>
                    @if ($this->selectedSiswaId)
                        <div class="" style="" id="form-submit" wire:loading.remove wire:target='transactionType,selectedSiswaId'>
                            <button wire:target='createTransaction' wire:loading.class='opacity-80' wire:click='createTransaction' class="btn btn-primary ml-auto">Simpan</button>
                        </div>
                    @endif
                    {{-- </form> --}}
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Mutasi tabungan</h3>
                    <div class="card-options">
                        <a href="{{ route('tabungan.export') }}" class="btn btn-primary btn-sm ml-2"
                            download="true">Export</a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table card-table table-hover table-vcenter text-wrap">
                        <thead>
                            <tr>
                                <th class="w-1">No.</th>
                                <th>Tanggal</th>
                                <th>Nama</th>
                                <th>KD</th>
                                <th>Keterangan</th>
                                <th>Jumlah</th>
                                <th>Cetak</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($this->tabungan as $index => $item)
                                <tr>
                                    <td><span class="text-muted">{{ $index + 1 }}</span></td>
                                    <td>{{ $item->created_at->format('d-m-Y') }}</td>
                                    <td>
                                        <a href="{{ route('siswa.show', $item->siswa->id) }}" target="_blank">
                                            {{ $item->siswa->nama }} -
                                            {{ $item->siswa->kelas->nama }} -
                                            {{ isset($item->siswa->kelas->periode) ? $item->siswa->kelas->periode->nama : '' }}
                                        </a>
                                    </td>
                                    <td>
                                        @if ($item->tipe == 'in')
                                            Menabung
                                        @elseif($item->tipe == 'out')
                                            Penarikan
                                        @endif
                                    </td>
                                    <td style="max-width:150px;">{{ $item->keperluan }}</td>
                                    <td>IDR. {{ format_idr($item->jumlah) }}</td>
                                    <td>
                                        <a class="btn btn-outline-primary btn-sm" target="_blank"
                                            href="{{ route('tabungan.transaksicetak', $item->id) }}">
                                            Cetak
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <div class="d-flex">
                        <div class="ml-auto mb-0">
                            {{ $this->tabungan->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
