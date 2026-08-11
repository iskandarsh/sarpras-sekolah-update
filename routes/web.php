<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ActivityLogController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-devextreme', function () {
    return view('test-devextreme');
})->middleware(['auth']);

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/activity-log', [ActivityLogController::class, 'index'])
        ->name('activity-log.index');

    Route::get('/ruangan/data', [RuanganController::class, 'data']);

    Route::resource('ruangan', RuanganController::class);

    Route::get('/barang/data', [BarangController::class, 'data'])
        ->name('barang.data');

    Route::resource('barang', BarangController::class);

    Route::get('/peminjaman/data', [PeminjamanController::class, 'data'])
        ->name('peminjaman.data');

    Route::resource('peminjaman', PeminjamanController::class);

    Route::get('/pengembalian/data', [PengembalianController::class, 'data']);

    Route::resource('pengembalian', PengembalianController::class);

    Route::get('/user/data', [UserController::class, 'data'])
        ->name('user.data');

    Route::resource('user', UserController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__ . '/auth.php';
