<?php

use App\Http\Controllers\Clients\ClientsController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('clients', [ClientsController::class, 'create'])->name('clients.create');
});
