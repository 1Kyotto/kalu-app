<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Users\LoginController;
use App\Http\Controllers\Users\LogoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\UserProfileController;

Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('user.login');
Route::post('/logout', [LogoutController::class, 'logout'])->name('user.logout');

Route::middleware('auth')->group(function () {
    Route::get('/kalu', [DashboardController::class, 'index'])->name('home.index');
    Route::get('/empleados', [DashboardController::class, 'empleados'])->name('empleados.info');
    Route::get('/empleados/create', [DashboardController::class, 'createEmpleado'])->name('empleados.create');
    Route::post('/empleados', [DashboardController::class, 'storeEmpleado'])->name('empleados.store');
    Route::post('/empleados/contract/upload', [DashboardController::class, 'uploadContract'])->name('empleados.contract.upload');

    Route::get('/ley-karin', [DashboardController::class, 'leykarin'])->name('leykarin.info');

    Route::get('/contrato', [DashboardController::class, 'contrato'])->name('contrato.info');

    Route::get('/solicitudes', [DashboardController::class, 'solicitudes'])->name('solicitudes.info');

    Route::get('/beneficios', [DashboardController::class, 'beneficios'])->name('beneficios.info');

    Route::get('/politicas-reglamento', [DashboardController::class, 'politicas'])->name('politicas.info');

    Route::get('/perfil/{id}', [DashboardController::class, 'edit'])->name('user.profile');

    Route::get('/download/contract/{id}', [DashboardController::class, 'download'])->name('contract.download');

    // Rutas para empleados
    Route::delete('/api/employees/{id}', [DashboardController::class, 'destroy'])->name('employees.destroy');
    Route::put('/api/employees/{id}/status', [DashboardController::class, 'updateStatus'])->name('employees.update.status');

    // Rutas de solicitudes
    Route::middleware(['auth'])->group(function () {
        Route::get('/solicitudes', [PermissionController::class, 'index'])->name('permissions.index');
        Route::get('/solicitudes/crear', [PermissionController::class, 'create'])->name('permissions.create');
        Route::post('/solicitudes', [PermissionController::class, 'store'])->name('permissions.store');
        Route::patch('/solicitudes/{id}/status', [PermissionController::class, 'updateStatus'])->name('permissions.update-status');
    });

    // Rutas de liquidaciones
    Route::middleware(['auth'])->group(function () {
        Route::get('/liquidaciones', [PayrollController::class, 'index'])->name('liquidaciones.info');
        Route::post('/payrolls', [PayrollController::class, 'store'])->name('payrolls.store');
        Route::get('/payrolls/{id}/download', [PayrollController::class, 'download'])->name('payrolls.download');
    });

    // Rutas de perfil de usuario
    Route::put('/user/{id}/profile', [UserProfileController::class, 'updateProfile'])->name('user.profile.update');
    Route::put('/user/{id}/password', [UserProfileController::class, 'updatePassword'])->name('user.password.update');
});
