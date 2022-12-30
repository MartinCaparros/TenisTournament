<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TournamentController;
use App\Models\Tournament;

Route::prefix('tournament')->name('tournament.')->group(function () {
    Route::post('emulate', [TournamentController::class, 'emulateTournament'])->name('emulate');
    Route::get('list'    , [TournamentController::class, 'getTournaments'])   ->name('list');
});
