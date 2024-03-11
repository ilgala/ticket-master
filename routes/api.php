<?php

use App\Http\Controllers\Authentication\LoginController;
use App\Http\Controllers\Authentication\LogoutController;
use App\Http\Controllers\Authentication\MeController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

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

Route::middleware('guest')
    ->post('login', LoginController::class)
    ->name('login');

Route::middleware('auth')
    ->group(function () {
        Route::match(['get', 'post'], 'logout', LogoutController::class)
            ->name('logout');

        Route::get('/me', MeController::class)
            ->name('me');

        Route::prefix('/ticket')
            ->name('ticket.')
            ->group(function () {
                Route::get('/created-by/{user:email}', [TicketController::class, 'createdBy'])
                    ->name('created-by');
                Route::get('/assigned-to/{user:email}', [TicketController::class, 'assignedTo'])
                    ->name('assigned-to');
                Route::get('/by-department/{department:code}', [TicketController::class, 'byDepartment'])
                    ->name('by-department');

                Route::post('/', [TicketController::class, 'store'])
                    ->name('store');
            });
    });
