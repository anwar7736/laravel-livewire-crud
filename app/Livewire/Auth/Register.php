<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class Register extends Component
{
    use WithFileUploads;
    public $name, $email, $phone, $photo, $password, $password_confirmation;
    public function register()
    {
       $inputs = $this->validate([
            'name'      => ['required', 'min:3'],
            'email'     => ['required', 'email', 'unique:users,email'],
            'phone'     => ['required', 'regex:/^(?:\+?88)?01[3-9]\d{8}$/', 'unique:users,phone'],
            'password'  => ['required', 'min:4', 'confirmed'],
            'photo'     => ['nullable', 'image', 'mimes:jpg,png,jpeg,svg,gif', 'max:2048']
        ]);
        if($this->photo){
            $inputs['photo'] = uploadFile($this->photo, "users");
        }

        $user = User::create($inputs);
        Auth::login($user);
        deleteTempImages();
        return $this->redirectRoute('contacts', navigate: true);
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
