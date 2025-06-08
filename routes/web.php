<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

// Do not delete! Temple Builder
use App\Livewire\TempleBuilder\TempleBuilder;
use App\Livewire\TempleBuilder\RouteExplorer;

// Dummy Components for Water Group
use App\Livewire\Home;
use App\Livewire\Groups\Water\Hydrogen;
use App\Livewire\Groups\Water\Oxygen;

// Route::get('/', function () {
//     return view('welcome');
// })->name('welcome');

Route::get('/', Home::class)->name('home');

// Do not delete Temple Builder Routes
Route::get('temple-builder', TempleBuilder::class)->name('temple-builder');
Route::get('route-explorer', RouteExplorer::class)->name('route-explorer');

// Dummy Components for Water Group
Route::get('/water/hydrogen', Hydrogen::class)->name('water.hydrogen');
Route::get('/water/oxygen', Oxygen::class)->name('water.oxygen');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');
    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
