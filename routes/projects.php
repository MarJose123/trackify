<?php

use App\Http\Controllers\Projects\ProjectsController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('projects')->group(function () {
    Route::get('/', [ProjectsController::class, 'index'])->name('projects.index');
    Route::get('/create', [ProjectsController::class, 'create'])->name('projects.create');
    Route::post('/create', [ProjectsController::class, 'store'])->name('projects.store');
    //    Route::get('/show/{client}', [ProjectsController::class, 'show'])->name('clients.show');
    //    Route::get('/edit/{client}', [ProjectsController::class, 'edit'])->name('clients.edit');
    //    Route::put('/update/{client}', [ProjectsController::class, 'update'])->name('clients.update');
    //    Route::delete('/delete/{client}', [ProjectsController::class, 'destroy'])->name('clients.destroy');

    //     axios route
    Route::prefix('_api')->group(function () {
        Route::get('/table-filter-status', [ProjectsController::class, 'tableFilterStatus'])->name('projects.table-filter-status');
    });
});
