<?php

use App\Http\Controllers\Clients\ClientsController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('clients')->group(function () {
    Route::get('/', [ClientsController::class, 'list'])->name('clients.list');
    Route::get('/create', [ClientsController::class, 'create'])->name('clients.create');

    // axios route
    Route::prefix('_api')->group(function () {
        Route::get('/table-filter-status', [ClientsController::class, 'tableFilterStatus'])->name('clients.table-filter-status');
    });
});
