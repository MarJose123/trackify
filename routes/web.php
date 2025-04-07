<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::middleware('auth')->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

Route::get('/test', function () {
    echo 'test';
    ray('test');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
require __DIR__.'/clients.php';
require __DIR__.'/projects.php';
require __DIR__.'/timer.php';
