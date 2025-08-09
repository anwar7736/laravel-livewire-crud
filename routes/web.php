<?php

use App\Http\Middleware\RedirectIfAuthenticated;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Logout;
use App\Livewire\Auth\Register;
use App\Livewire\ContactCrud;
use App\Livewire\Welcome;
use App\Livewire\PurchaseCreate;
use Illuminate\Support\Facades\Route;



Route::middleware(RedirectIfAuthenticated::class)->group(function () {
    Route::get('/', Welcome::class)->name('home');
    Route::get('/login', Login::class)->name('login');
    Route::get('/register', Register::class)->name('register');
});


Route::group(['middleware' => ['auth']], function () {
    Route::get('/contacts', ContactCrud::class)->name('contacts');
    Route::get('/purchase-create', PurchaseCreate::class)->name('purchase.create');
});
