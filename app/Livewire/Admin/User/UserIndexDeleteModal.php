<?php

namespace App\Livewire\Admin\User;

use App\User;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class UserIndexDeleteModal extends Component
{
    public $selectedUserId;
    public $modalId;

    #[Computed]
    public function user()
    {
        return User::find($this->selectedUserId);
    }

    #[On('open-modal')]
    public function onOpenModal($modalId, $userId)
    {
        $this->selectedUserId = $userId;
    }

    public function delete(User $user)
    {
        $this->reset('selectedUserId');
        $user->delete();
        $this->dispatch('refresh-user', 'success', 'User berhasil dihapus');
    }

    public function render()
    {
        return view('livewire.admin.user.user-index-delete-modal');
    }
}
