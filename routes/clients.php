<?php

use App\Http\Controllers\Clients\ClientsController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('clients')->group(function () {
    Route::get('/', [ClientsController::class, 'list'])->name('clients.list');
    Route::get('/create', [ClientsController::class, 'create'])->name('clients.create');
    Route::post('/create', [ClientsController::class, 'store'])->name('clients.store');
    Route::get('/show/{client}', [ClientsController::class, 'show'])->name('clients.show');
    Route::get('/edit/{client}', [ClientsController::class, 'edit'])->name('clients.edit');
    Route::put('/update/{client}', [ClientsController::class, 'edit'])->name('clients.update');

    // axios route
    Route::prefix('_api')->group(function () {
        Route::get('/table-filter-status', [ClientsController::class, 'tableFilterStatus'])->name('clients.table-filter-status');
    });
});
