{{-- Global Toast Notification - Listens for Livewire 'notify' events --}}
<div x-data="{
    toasts: [],
    add(event) {
        const id = Date.now();
        this.toasts.push({
            id: id,
            type: event.detail.type || 'success',
            msg: event.detail.msg || '',
        });
        setTimeout(() => this.remove(id), 3500);
    },
    remove(id) {
        this.toasts = this.toasts.filter(t => t.id !== id);
    },
    icon(type) {
        return type === 'success' ? 'fe-check' : 'fe-alert-triangle';
    },
    alertClass(type) {
        return 'alert-' + (type || 'success');
    }
}"
    x-on:notify.window="add($event)"
    class="position-fixed top-0 end-0 p-3" style="z-index: 1090;">

    <template x-for="toast in toasts" :key="toast.id">
        <div class="alert d-flex align-items-center shadow-sm mb-2"
            :class="alertClass(toast.type)"
            style="min-width: 300px; animation: slideInRight 0.3s ease-out;"
            role="alert">
            <i class="fe me-2" :class="icon(toast.type)" aria-hidden="true"></i>
            <span x-text="toast.msg"></span>
            <button type="button" class="btn-close ms-auto" @click="remove(toast.id)"></button>
        </div>
    </template>
</div>

<style>
    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(100%);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
</style>
