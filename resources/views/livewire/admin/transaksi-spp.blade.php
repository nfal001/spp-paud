<div>
    <div class="page-header">
        <h1 class="page-title">
            Transaksi SPP
        </h1>
    </div>
    <div class="row gy-2">
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
                    {{-- <form action="{{ route('keuangan.store') }}" method="post"> --}}
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
                            <div class="form-group mb-2">
                                <label class="form-label">Siswa</label>
                                <select id="siswa" class="form-control" name="siswa_id" wire:model.live='siswaId'>
                                    <option value="#">[-- Pilih Siswa --]</option>
                                    @foreach ($this->listSiswa as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->nama . ' - ' . $item->kelas->nama . ' - ' }} </option>
                                    @endforeach
                                </select><br>
                                @if ($this->siswaDetail)
                                    @php
                                        $saldo = $this->saldoSiswa;
                                    @endphp
                                    <span wire:loading.remove wire:target='siswaId'>
                                        @if ($saldo['isValidSaldo'])
                                            Saldo: IDR. <span id="saldo">{{ $saldo['saldo'] }}</span>
                                        @else
                                            Saldo: IDR. <span id="saldo"
                                                class="text-danger">{{ $saldo['saldo'] }}</span>
                                        @endif
                                    </span>
                                @endif
                                <div wire:loading wire:target='siswaId' class="fst-italic text-muted"><span
                                        class="spinner-border"></span> Loading...</div>
                            </div>
                            @if ($this->siswaDetail)
                                <hr wire:loading.remove wire:target='siswaId' />
                                <div class="form-group mb-2" style="" id="form-tagihan" wire:loading.remove
                                    wire:target='siswaId'>
                                    <label class="form-label">Tagihan</label>
                                    <select id="tagihan" class="form-control" name="tagihan_id"
                                        wire:model.live='tagihanId'>
                                        <option value="#">[-- Pilih Tagihan --]</option>
                                        @foreach ($this->listTagihan as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-2" style="" id="form-tagihan-2" wire:loading.remove
                                    wire:target='siswaId'>
                                    <label class="form-label">
                                        Total Tagihan IDR:
                                        <span wire:loading wire:target='tagihanId'>Loading ... </span>
                                        <span id="harga" wire:loading.remove
                                            wire:target='tagihanId'>{{ optional($this->tagihan)->jumlah ?? 0 }}</span>
                                    </label>
                                    <label class="ms-2 custom-switch">
                                        <input type="checkbox" class="custom-switch-input" wire:model.live='hasDiscount'
                                            id="ada-diskon">
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description">Ada diskon? </span>
                                    </label>
                                </div>
                                <div wire:show='hasDiscount' class="form-group mb-2" style="" id="form-diskon"
                                    wire:loading.remove wire:target='siswaId'>
                                    <label class="form-label">Diskon (IDR)</label>
                                    <input type="text" name="diskon" id="diskon" class="form-control" wire:model.live='totalDiscount'
                                        placeholder="masukan angka dalam satuan mata uang, tanpa titik atau koma">
                                </div>
                                <div class="form-group mb-2" style="" id="form-total" wire:loading.remove
                                    wire:target='siswaId'>
                                    <label class="form-label">Total Pembayaran</label>
                                    <input type="text" name="pembayaran" class="form-control" id="total"
                                        value="{{ (optional($this->tagihan)->jumlah ?? 0) - $totalDiscount }}" disabled>
                                </div>
                                <div class="form-group mb-2" style="" id="form-pembayaran" wire:loading.remove
                                    wire:target='siswaId'>
                                    <label class="form-label">Pembayaran</label>
                                    <div class="selectgroup w-100">
                                        <label class="selectgroup-item">
                                            <input type="radio" name="via" value="tunai" wire:model.live='paymentType'
                                                class="selectgroup-input">
                                            <span class="selectgroup-button">Tunai</span>
                                        </label>
                                        <label class="selectgroup-item" style="" id="opsi-tabungan">
                                            <input type="radio" name="via" value="tabungan" wire:model.live='paymentType'
                                                class="selectgroup-input">
                                            <span class="selectgroup-button">Potong Tabungan</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group mb-2" style="" id="form-keterangan" wire:loading.remove
                                    wire:target='siswaId'>
                                    <label class="form-label">Keterangan</label>
                                    <textarea name="keterangan" id="keterangan" rows="3" class="form-control"></textarea>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div wire:loading.remove wire:target='siswaId'>
                        @if ($this->siswaDetail)
                            <button class="btn btn-primary ml-auto" style="" id="btn-simpan">Simpan</button>
                        @endif
                    </div>
                    {{-- </form> --}}
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Histori Transaksi</h3>
                    <div class="card-options">
                        <a href="{{ route('transaksi.export') }}" class="btn btn-primary btn-sm me-1"
                            download="true">Export</a>
                        <a href="#!cetak" class="btn btn-outline-primary btn-sm ml-2" id="mass-cetak">Cetak</a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table card-table table-hover table-vcenter text-wrap">
                        <thead>
                            <tr>
                                <th class="w-1">No.</th>
                                <th>Tanggal</th>
                                <th>Siswa</th>
                                <th>Tagihan</th>
                                <th>Diskon</th>
                                <th>Dibayarkan</th>
                                <th>Keterangan</th>
                                <th>Cetak</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($this->listTransaksi as $index => $item)
                                <tr>
                                    <td><span class="text-muted">{{ $index + 1 }}</span></td>
                                    <td>{{ $item->created_at->format('d-m-Y') }}</td>
                                    <td>
                                        <a href="{{ route('siswa.show', $item->siswa->id) }}" target="_blank">
                                            {{ $item->siswa->nama . '(' . $item->siswa->kelas->nama . ')' }}
                                        </a>
                                    </td>
                                    <td>{{ $item->tagihan->nama }}</td>
                                    <td>IDR. {{ format_idr($item->diskon) }}</td>
                                    <td>IDR. {{ format_idr($item->keuangan->jumlah) }}</td>
                                    <td style="max-width:150px;">{{ $item->keterangan }}</td>
                                    <td>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input tandai"
                                                name="example-checkbox2" value="{{ $item->id }}">
                                            <span class="custom-control-label">Tandai</span>
                                        </label>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <div class="d-flex">
                        <div class="ml-auto mb-0">
                            {{ 22 ?? $transaksi->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
