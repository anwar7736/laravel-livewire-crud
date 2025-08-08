<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public $email, $password;
    public function login()
    {
        $inputs = $this->validate([
            'email'    => ['required', 'email', 'exists:users'],
            'password' => ['required']
        ]);

        if(Auth::attempt($inputs)){
            return $this->redirectRoute('contacts', navigate: true);
        }

        $this->addError('email', 'Invalid credentials!');

    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
