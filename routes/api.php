<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController; 

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Semua route API otomatis pakai prefix "/api"
|--------------------------------------------------------------------------
*/

// 🔑 Auth
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

// 👤 Info user login
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// 📌 Absensi (hanya user yang login bisa akses)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/absensi', [AbsensiController::class, 'store']);        
    Route::get('/absensi/history', [AbsensiController::class, 'history']); 
    Route::get('/time', [AbsensiController::class, 'time']); // ✅ endpoint baru
    Route::post('/absensi/izin', [AbsensiController::class, 'store']);
    Route::post('/profile/upload-photo', [ProfileController::class, 'uploadPhoto']);
    Route::delete('/profile/remove-photo', [ProfileController::class, 'removePhoto']);

    // 📌 Task (baru)
    Route::get('/tasks', [TaskController::class, 'index']);         // ambil semua tugas user
    Route::put('/tasks/{task}', [TaskController::class, 'update']); // update status/komentar tugas
});
