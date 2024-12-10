<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware(['web', 'auth'])->group(function () {
    Route::put('/employees/{id}/status', [DashboardController::class, 'updateEmployeeStatus']);
    Route::post('/employees/contract/upload', [DashboardController::class, 'uploadContract']);
    Route::delete('/employees/{id}', [DashboardController::class, 'destroy']);
});
