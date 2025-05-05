<?php

use App\Http\Controllers\ExpedienteController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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
    return redirect()->route('login');
});

// Rutas de autenticación
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('expedientes.index');
    })->name('dashboard');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Rutas para expedientes
    Route::resource('expedientes', ExpedienteController::class);
    Route::patch('expedientes/{expediente}/restore', [ExpedienteController::class, 'restore'])->name('expedientes.restore')->withTrashed();
});

require __DIR__.'/auth.php';