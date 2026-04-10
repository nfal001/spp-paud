<?php

namespace App\Livewire\Admin\User;

use App\User;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

class UserIndex extends Component
{
    public $limit = 5;

    #[Computed]
    public function users()
    {
        return User::orderBy('created_at', 'desc')->paginate($this->limit);
    }

    public function promptDelete($id)
    {
        $this->dispatch('open-modal', modalId: 'deleteModal-user', userId: $id);
    }

    #[On('refresh-user')]
    public function refreshUser($type, $message)
    {
        unset($this->users);
    }

    #[Title('Daftar Pengguna')]
    public function render()
    {
        return view('livewire.admin.user.user-index')->layout('layouts.app');
    }
}
