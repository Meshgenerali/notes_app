<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoteController;

Route::get('/', function () {
    $notes = auth()->check() ? auth()->user()->notes()->latest()->get() : collect();
    return view('welcome', compact('notes'));
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('notes.index');
    })->name('dashboard');

    Route::controller(NoteController::class)->group(function () {
    Route::post('/notes', 'store')->name('notes.store');
    Route::get('/notes', 'index')->name('notes.index');
    Route::get('/notes/{note}', 'show')->name('notes.show');
    Route::put('/notes/{note}', 'update')->name('notes.update');
});

});

