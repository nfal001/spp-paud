<div>
    <div class="modal fade" id="{{ $modalId }}" tabindex="-1" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered"
            x-on:open-modal.window="console.log($event, $event.detail.modalId); tabler.Modal.getOrCreateInstance('#' + $event.detail.modalId).show();">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Data Periode</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if ($selectedPeriodeId)
                        Apakah anda yakin ingin menghapus data Periode <b>{{ $this->periode->nama }}</b> ini?
                    @else
                        <div class="text-center">
                            <div class="spinner-border spinner-border-sm me-2" wire:loading
                                wire:target='$selectedPeriodeId'></div>
                            <span>Memuat data...</span>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    @if ($selectedPeriodeId)
                        <button type="button" class="btn me-auto" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                            wire:click='delete({{ $selectedPeriodeId }})'>Hapus</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
