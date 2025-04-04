<?php

use App\Http\Controllers\Clock\ClockController;

Route::middleware(['auth'])->prefix('clocks')->group(function () {
    Route::get('/', [ClockController::class, 'index'])->name('clocks.index');
});
