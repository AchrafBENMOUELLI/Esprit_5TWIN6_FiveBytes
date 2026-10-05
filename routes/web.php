<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('welcome'));
Route::get('/login', fn () => view('components.authentification.logincomponent'))->name('login');
Route::get('/register', fn () => view('components.authentification.registercomponent'))->name('register');
