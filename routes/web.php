<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes(['register' => false, 'verify' => true]);

Route::redirect('/', 'home');

Route::middleware(['auth', 'verified'])->group(function () {
    // Home
    Route::get('home', 'HomeController@index')->name('home');

    // Admin
    Route::middleware(['role:admin'])->group(function () {
        // Clients
        Route::resource('clients', 'ClientController', ['except' => ['create', 'destroy', 'edit']]);
        Route::put('clients', 'ClientController@status');

        // Punches
        Route::resource('punches', 'PunchController', ['only' => ['index']]);
    });
});
