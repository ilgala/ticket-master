<?php

use App\Models\User;
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

Route::post('/login', function () {
    $credentials = request(['email', 'password']);

    $user = User::where('email', $credentials['email'])->first();
    if (!$user || !Hash::check($credentials['password'], $user->password)) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    Auth::guard('api')->setUser($user);
    /** @var \App\Authentication\JwtManager $manager */
    $manager = app()->make('jwt-manager');

    return response()->json([
        'token' => $manager->userToToken(
            Auth::guard('api')->user()
        )->toString(),
        'refreshToken' => $manager->userToToken(
            Auth::guard('api')->user(),
            now()->addDays(15)
        )->toString(),
    ]);
});

Route::middleware('auth:api')->get('/user', function (\Illuminate\Http\Request $request) {
    return $request->user();
});

Route::middleware('auth:api')
    ->group(function () {
        // Other routes...
    });

Route::get('/ticket/created-by/{user:email}', [\App\Http\Controllers\TicketController::class, 'createdBy']);
Route::get('/ticket/assigned-to/{user:email}', [\App\Http\Controllers\TicketController::class, 'assignedTo']);
Route::get('/ticket/by-department/{department:code}', [\App\Http\Controllers\TicketController::class, 'byDepartment']);
