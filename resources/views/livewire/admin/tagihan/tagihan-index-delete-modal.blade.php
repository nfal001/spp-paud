<div>
    <div class="modal fade" id="{{ $modalId }}" tabindex="-1" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered"
            x-on:open-modal.window="console.log($event, $event.detail.modalId); tabler.Modal.getOrCreateInstance('#' + $event.detail.modalId).show();">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Data Tagihan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if ($selectedTagihanId)
                        Apakah anda yakin ingin menghapus data Tagihan <b>{{ $this->tagihan->nama }}</b> ini?
                    @else
                        <div class="text-center">
                            <div class="spinner-border spinner-border-sm me-2" wire:loading
                                wire:target='selectedTaghi$selectedTagihanId'></div>
                            <span>Memuat data...</span>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    @if ($selectedTagihanId)
                        <button type="button" class="btn me-auto" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                            wire:click='delete({{ $selectedTagihanId }})'>Hapus</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
