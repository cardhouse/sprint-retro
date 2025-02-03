<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::get('/retro', function () {
    $board = App\Models\RetroBoard::create([
        'token' => str()->random(8),
    ]);

    return redirect()->to('/retro/'.$board->token);
});

Route::get('/retro/{token}', App\Livewire\RetroBoardComponent::class)
    ->name('retro');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
