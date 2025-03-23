<?php

use App\Http\Controllers\Projects\ProjectsController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('projects')->group(function () {
    Route::get('/', [ProjectsController::class, 'index'])->name('projects.index');
    Route::get('/create', [ProjectsController::class, 'create'])->name('projects.create');
    Route::post('/create', [ProjectsController::class, 'store'])->name('projects.store');
    Route::get('/show/{project}', [ProjectsController::class, 'show'])->name('projects.show');
    Route::get('/edit/{project}', [ProjectsController::class, 'edit'])->name('projects.edit');
    Route::put('/update/{project}', [ProjectsController::class, 'update'])->name('projects.update');
    Route::delete('/delete/{project}', [ProjectsController::class, 'destroy'])->name('projects.destroy');

    //     axios route
    Route::prefix('_api')->group(function () {
        Route::get('/table-filter-status', [ProjectsController::class, 'tableFilterStatus'])->name('projects.table-filter-status');
    });
});
