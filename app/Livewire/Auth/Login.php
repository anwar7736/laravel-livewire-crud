<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public $email, $password, $isRemember;
    public function rules() : array {
        return [
            'email'    => ['required', 'email', 'exists:users'],
            'password' => ['required']
        ];
    }
    public function login()
    {
        $inputs = $this->validate();

        if (Auth::attempt($inputs)) {
            if ($this->isRemember) {
                session()->put('email', $this->email);
                session()->put('password', $this->password);
            } else {
                session()->forget('email');
                session()->forget('password');
            }
            return $this->redirectRoute('contacts', navigate: true);
        }

        $this->addError('email', 'Invalid credentials!');
    }

    public function updated($property)
    {
        $this->validate();
    }

    public function render()
    {
        $this->email      = session('email', '');
        $this->password   = session('password', '');
        $this->isRemember = $this->email && $this->password;
        return view('livewire.auth.login');
    }
}
