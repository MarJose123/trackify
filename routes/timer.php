<?php

use App\Http\Controllers\Clock\TimerController;

Route::middleware(['auth'])->prefix('timer')->group(function () {
    Route::get('/', [TimerController::class, 'index'])->name('timer.index');
});
