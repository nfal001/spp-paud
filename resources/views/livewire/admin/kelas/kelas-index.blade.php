<div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title me-2">List Kelas</h3>
                    <a href="{{ route('web.admin.kelas.tambah') }}" wire:navigate
                        class="btn btn-outline-primary btn-sm me-2">Tambah Kelas</a>
                    <span class="spinner-border spinner-border-sm" wire:loading></span>
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
                                <th>Periode</th>
                                <th>Nama</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($this->kelas as $index => $item)
                                <tr wire:key='{{ md5($item) }}'>
                                    <td><span class="text-muted">{{ $index + 1 }}</span></td>
                                    <td>{{ isset($item->periode) ? $item->periode->nama : '-' }}</td>
                                    <td>
                                        {{ $item->nama }}
                                    </td>
                                    <td class="text-center">
                                        <a class="btn btn-sm btn-outline-primary" wire:navigate
                                            href="{{ route('web.admin.kelas.edit', $item->id) }}" title="edit item">
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
                            {{ $this->kelas->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <livewire:admin.kelas.kelas-index-delete-modal modalId="deleteModal-kelas" />
    </div>
</div>
