<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Enums\UserRole;

Route::get('/', fn () => view('welcome'));

Route::get('/login', fn () => view('components.authentification.logincomponent'))
    ->middleware('guest')
    ->name('login');

Route::get('/register', fn () => view('components.authentification.registercomponent'))
    ->middleware('guest')
    ->name('register');

Route::get('/dashboard', function (Request $request) {
    if ($request->user()->role === UserRole::Citoyen) {
        return redirect('/');
    }

    return view('components.dashboard.dashboard');
})->middleware('auth')->name('dashboard');

require __DIR__.'/auth.php';
require __DIR__.'/front/project.php';
