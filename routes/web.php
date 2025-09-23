<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    return redirect('/absensi'); // 🚀 langsung arahkan ke panel
});


Route::get('/gate-check', function () {
    $user = Auth::user();
    return [
        'user' => $user,
        'can_filament' => $user ? Gate::allows('filament', $user) : false,
    ];
});