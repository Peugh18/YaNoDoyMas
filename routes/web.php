<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('usuarios', function () {
        return Inertia::render('Usuarios');
    })->name('usuarios');
    Route::get('productos', function () {
        return Inertia::render('Productos');
    })->name('productos');
    Route::get('subastas', function () {
        return Inertia::render('Subastas');
    })->name('subastas');
    Route::get('ventas', function () {
        return Inertia::render('Ventas');
    })->name('ventas');
    Route::get('micoins', function () {
        return Inertia::render('MiCoins');
    })->name('micoins');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
