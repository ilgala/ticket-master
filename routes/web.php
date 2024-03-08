<?php

use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

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

Route::get('{path}', function () {
    return response()->json(['message' => 'Unauthorized'], SymfonyResponse::HTTP_UNAUTHORIZED);
})->where('path', '(.*)');

// Route::get('/', \App\Livewire\TicketForm::class);
