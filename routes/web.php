<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Users\LoginController;
use App\Http\Controllers\DashboardController;

Route::get('/', [LoginController::class, 'index'])->name('user.login');
Route::post('/', [LoginController::class, 'login']);

Route::middleware('auth')->group(function () {
    Route::get('/empleados', [DashboardController::class, 'empleados'])->name('empleados.info');

    Route::get('/ley-karin', [DashboardController::class, 'index'])->name('leykarin.info');

    Route::get('/contrato', [DashboardController::class, 'contrato'])->name('contrato.info');

    Route::get('/liquidaciones', [DashboardController::class, 'liquidaciones'])->name('liquidaciones.info');

    Route::get('/solicitudes', [DashboardController::class, 'solicitudes'])->name('solicitudes.info');

    Route::get('/beneficios', [DashboardController::class, 'beneficios'])->name('beneficios.info');

    Route::get('/politicas-reglamento', [DashboardController::class, 'politicas'])->name('politicas.info');
});
