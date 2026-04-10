<div>
    @section('page-name', 'Siswa')
    <div class="page-header d-flex justify-content-between flex-row">
        <h1 class="page-title">
            @yield('page-name')
        </h1>
        <div class="page-options d-flex my-2">
            <div class="input-icon ml-2">
                <form action="" method="GET">
                    <span class="input-icon-addon">
                        <x-lucide-search width="18" height="18" />
                    </span>
                    <input type="text" class="form-control w-10" placeholder="Cari Siswa, masukan nama" name="search"
                        wire:model.live='search'>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header gap-2">
                    <h3 class="card-title">@yield('page-name')</h3>
                    <a wire:navigate href="{{ route('web.admin.siswa.tambah') }}"
                        class="btn btn-outline-primary btn-sm ml-5">Tambah Siswa</a>
                    <span class="spinner-border spinner-border-sm me-2" wire:loading
                        wire:target='search,isOrphan'></span>
                    <div class="card-options gap-2">
                        <label for="isOrphan">Filter Siswa Yatim</label>
                        <input type="checkbox" name="isOrphan" id="isOrphan" wire:model.live='isOrphan'>
                        {{-- <a href="{{ route('siswa.showimport') }}" class="btn btn-primary btn-sm">Import</a> --}}
                        <a wire:click='export' wire:loading.class='opacity-75' wire:target='export' class="btn btn-secondary btn-sm ml-2"
                            download="true">Export</a>
                    </div>
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
                <div class="table-responsive">
                    <table class="table card-table table-hover table-vcenter text-nowrap">
                        <thead>
                            <tr>
                                <th class="w-1">No.</th>
                                <th>Kelas</th>
                                <th>Nama</th>
                                <th>Wali</th>
                                <th>Telp. Wali</th>
                                <th>Yatim</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($this->siswa as $index => $item)
                                <tr wire:key='{{ md5($item) }}'>
                                    <td><span class="text-muted">{{ $index + 1 }}</span></td>
                                    <td> {{ $item->kelas->nama }}{{ isset($item->kelas->periode) ? '(' . $item->kelas->periode->nama . ')' : '' }}
                                    </td>
                                    <td>
                                        <a href="{{ route('siswa.show', $item->id) }}" class="link-unmuted">
                                            {{ $item->nama }}
                                        </a>
                                    </td>
                                    <td>
                                        {{ $item->nama_wali }}
                                    </td>
                                    <td>
                                        {{ $item->telp_wali }}
                                    </td>
                                    <td>
                                        @if ($item->is_yatim)
                                            <span class="tag tag-green">Ya</span>
                                        @else
                                            <span class="tag tag-green">Tidak</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a class="btn btn-outline-primary btn-sm"
                                            href="{{ route('siswa.show', $item->id) }}" title="lihat detail">
                                            <x-lucide-eye width="18" height="18" />
                                        </a>
                                        <a class="btn btn-sm btn-outline-primary"
                                            wire:navigate href="{{ route('web.admin.siswa.edit', $item->id) }}" title="edit item">
                                            <x-lucide-edit width="18" height="18" />
                                        </a>
                                        <button class="btn btn-sm btn-outline-danger"
                                            wire:click='promptDelete("{{ $item->id }}")' title="delete item">
                                            <x-lucide-trash width="18" height="18" wire:loading.remove
                                                wire:target='promptDelete("{{ $item->id }}")' />
                                            <span class="spinner-border" wire:loading
                                                wire:target='promptDelete("{{ $item->id }}")'></span>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <div class="d-flex">
                        <div class="ml-auto mb-0">
                            Total: {{ $this->siswa->count() }} Santri
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <livewire:admin.siswa.siswa-index-modal modalId="deleteModal-siswa">
</div>
