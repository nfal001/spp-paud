<div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title me-2">List Periode</h3>
                    <a href="{{ route('web.admin.periode.tambah') }}" wire:navigate class="btn btn-outline-primary btn-sm ml-5">Tambah Periode</a>
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
                                <th>Nama</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th>Aktif</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($this->periode as $index => $item)
                                <tr wire:key='{{ md5($item) }}'>
                                    <td><span class="text-muted">{{ $index + 1 }}</span></td>
                                    <td>{{ $item->nama }}</td>
                                    <td>
                                        {{ $item->tgl_mulai }}
                                    </td>
                                    <td>
                                        {{ $item->tgl_selesai }}
                                    </td>
                                    <td>
                                        @if ($item->is_active)
                                            <span class="tag tag-green">Aktif</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a class="btn btn-sm btn-outline-primary" wire:navigate
                                            href="{{ route('web.admin.periode.edit', $item->id) }}" title="edit item">
                                            <x-lucide-edit width="16" height="16" />
                                        </a>
                                        <button class="btn btn-sm btn-outline-danger"
                                            wire:click='promptDelete("{{ $item->id }}")' title="delete item">
                                            <x-lucide-trash width="16" height="16" wire:loading.remove
                                                wire:target='promptDelete("{{ $item->id }}")' />
                                            <span class="spinner-border spinner-border-sm" wire:loading
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
                            {{ $this->periode->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <livewire:admin.periode.periode-index-delete-modal modalId="deleteModal-periode" />
</div>
