<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard/Index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('usuarios', function () {
        return Inertia::render('Usuario/Index');
    })->name('usuarios');
    Route::resource('productos', ProductController::class);
    Route::get('subastas', function () {
        return Inertia::render('Subasta/Index');
    })->name('subastas');
    Route::get('ventas', function () {
        return Inertia::render('Ventas/Index');
    })->name('ventas');
    Route::get('micoins', function () {
        return Inertia::render('MiCoins/Index');
    })->name('micoins');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
