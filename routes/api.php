<?php

use App\Http\Controllers\Api\ContactFormController;
use App\Http\Controllers\Api\GoogleCalendarController;
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

Route::post('/contact/submit', [ContactFormController::class, 'contactSubmit']);
Route::put('/contact/update/{id}', [ContactFormController::class, 'updateContactSchedule']);

Route::get('/calendar/times/{date}', [GoogleCalendarController::class, 'getAvailableTimes']);
