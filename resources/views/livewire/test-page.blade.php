<div>
    {{-- Success is as dangerous as failure. --}}
    <a href="#" class="btn" role="button">Link</a>
    <button class="btn" wire:click="$refresh">
        <span class="spinner-border spinner-border-sm me-2" role="status" wire:loading></span>
        Button Refresh
    </button>
    <input type="button" class="btn" value="Input" />
    <input type="submit" class="btn" value="Submit" />
    <input type="reset" class="btn" value="Reset" />

    <div>
        {{ now() }}
    </div>
</div>
