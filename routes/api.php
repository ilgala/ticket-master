<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/ticket/created-by/{user:email}', [\App\Http\Controllers\TicketController::class, 'createdBy']);
Route::get('/ticket/assigned-to/{user:email}', [\App\Http\Controllers\TicketController::class, 'assignedTo']);
Route::get('/ticket/by-department/{department:code}', [\App\Http\Controllers\TicketController::class, 'byDepartment']);
