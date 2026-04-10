<?php

namespace App\Livewire\Admin\User;

use App\User;
use Livewire\Component;

class UserEdit extends Component
{

    public User $user;

    public $name;
    public $email;
    public $password;
    public $passwordConfirmation;
    public $role;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'password' => 'nullable|string|min:8|same:passwordConfirmation',
        'passwordConfirmation' => 'nullable|string|min:8|same:password',
        'role' => 'required|in:SuperAdmin,Admin,Bendahara',
    ];

    public function updated($prop)
    {
        $this->validateOnly($prop);
    }

    public function submit()
    {
        $this->validate();

        if ($this->password != null) {
            $this->user->fill([
                'name' => $this->name,
                'email' => $this->email,
                'password' => $this->password,
                'role' => $this->role,
            ]);
        } else {
            $this->user->fill([
                'name' => $this->name,
                'email' => $this->email,
                'role' => $this->role,
            ]);
        }

        if ($this->user->save()) {
            $this->dispatch('refresh-user', 'success', 'pengguna berhasil diubah');
            return redirect()->route('web.admin.user.index');
        }

        $this->addError('error', 'Err.., terjadi kesalahan');
    }

    public function mount()
    {
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->role = $this->user->role;
    }

    public function render()
    {
        return view('livewire.admin.user.user-edit')->layout('layouts.app');
    }
}
