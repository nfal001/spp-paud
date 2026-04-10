<?php

namespace App\Livewire\Admin\User;

use App\User;
use Livewire\Component;

class TambahUser extends Component
{
    public $name;
    public $email;
    public $password;
    public $passwordConfirmation;
    public $status;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:8',
        'passwordConfirmation' => 'required|same:password',
        'status' => 'required|in:SuperAdmin,Admin,Bendahara',
    ];

    public function submit()
    {
        $this->validate();

        $user = User::make([
            'name' => $this->name,
            'email' => $this->email,
            'password' => bcrypt($this->password),
            'role' => $this->status,
        ]);

        if ($user->save()) {
            $this->redirectRoute('web.admin.user.index', [
                'type' => 'success',
                'msg' => 'User ditambahkan'
            ]);
        } else {
            dump("ERR");
            $this->redirectRoute('web.admin.user.index', [
                'type' => 'danger',
                'msg' => 'Err.., Terjadi Kesalahan'
            ]);
        }

        $this->dispatch('refresh-user', 'success', 'Data User berhasil ditambahkan');
    }

    public function render()
    {
        return view('livewire.admin.user.tambah-user')->layout('layouts.app');
    }
}
