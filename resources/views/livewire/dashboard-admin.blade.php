<div>
    <div class="page-header">
        <h1 class="page-title">
            Dashboard
        </h1>
    </div>
    <div class="row gy-3">
        <div class="col-6 col-sm-3 col-lg-3">
            <div class="card">
                <div class="card-body p-3 text-center">
                    <div class="h1 m-0">IDR {{ format_idr($this->statistics->totalUang ?? 0) }}</div>
                    <div class="text-muted mb-4">Total Uang</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-3 col-lg-3">
            <div class="card">
                <div class="card-body p-3 text-center">
                    <div class="h1 m-0">IDR {{ format_idr($this->statistics->totalUangMasuk ?? 0) }}</div>
                    <div class="text-muted mb-4">Total Uang Masuk</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-3 col-lg-3">
            <div class="card">
                <div class="card-body p-3 text-center">
                    <div class="h1 m-0">IDR {{ format_idr($this->statistics->totalUangKeluar ?? 0) }}</div>
                    <div class="text-muted mb-4">Total Uang Keluar</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-3 col-lg-3">
            <div class="card">
                <div class="card-body p-3 text-center">
                    <div class="h1 m-0">IDR {{ format_idr($this->statistics->totalUangSPP ?? 0) }}</div>
                    <div class="text-muted mb-4">Total Uang SPP</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-3 col-lg-3">
            <div class="card">
                <div class="card-body p-3 text-center">
                    <div class="h1 m-0">IDR {{ format_idr($this->statistics->totalUangTabungan ?? 0) }}</div>
                    <div class="text-muted mb-4">Total Uang Tabungan</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-3 col-lg-3">
            <div class="card">
                <div class="card-body p-3 text-center">
                    <div class="h1 m-0">{{ $this->statistics->totalSiswa }}</div>
                    <div class="text-muted mb-4">Siswa</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-3 col-lg-3">
            <div class="card">
                <div class="card-body p-3 text-center">
                    <div class="h1 m-0">{{ $this->statistics->totalKelas }}</div>
                    <div class="text-muted mb-4">Kelas</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-3 col-lg-3">
            <div class="card">
                <div class="card-body p-3 text-center">
                    <div class="h1 m-0">{{ $this->statistics->totalTagihan }}</div>
                    <div class="text-muted mb-4">Item Tagihan</div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Laporan Harian : {{ $filterDate }}</h3>
                    <div class="card-options gap-1">
                        <input class="form-control mr-2" type="date" name="" style="max-width: 200px"
                            wire:model.live='filterDate' id="date">
                        <button wire:click='cetakReport' id="btn-cetak-spp" class="btn btn-primary mr-1" value="#"
                            wire:loading.class='opacity-50' wire:target='cetakReport'>Cetak</button>
                        <button wire:click='exportReport' id="btn-export-spp" class="btn btn-primary"
                            wire:loading.class='opacity-50' wire:target='exportReport'>Export</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="my-5 text-center w-100" wire:loading wire:target='filterDate'>
                        Loading...
                    </div>
                    <table wire:loading.remove wire:target='filterDate'
                        class="table card-table table-hover table-vcenter text-nowrap title" id="print">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Nama</th>
                                <th>Pembayaran</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($this->getListTransaksiHarian as $item)
                                <tr>
                                    <td>{{ $item->created_at->format('d-m-Y') }}</td>
                                    <td>{{ $item->siswa->nama }}</td>
                                    <td>{{ $item->tagihan->nama }}</td>
                                    <td>IDR. {{ format_idr($item->keuangan->jumlah) }}</td>
                                    @php
                                        $jumlah += $item->keuangan->jumlah;
                                    @endphp
                                </tr>
                            @empty
                                <tr>
                                    <td class="opacity-75 fst-italic">Belum ada Transaksi Hari ini..</td>
                                </tr>
                            @endforelse
                            <tr>
                                <td><b>Total</b></td>
                                <td></td>
                                <td></td>
                                <td>IDR. {{ format_idr(0) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
