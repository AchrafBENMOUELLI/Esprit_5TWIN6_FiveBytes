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
    // Si c'est un citoyen, rediriger vers la page d'accueil front-office
    if ($request->user()->role === UserRole::Citoyen) {
        return redirect()->route('front.home');
    }

    // Sinon, afficher le dashboard admin/gestionnaire
    return view('components.dashboard.dashboard');
})->middleware('auth')->name('dashboard');

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
require __DIR__.'/front.php';
