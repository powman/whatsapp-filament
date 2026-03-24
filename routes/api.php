<?php

use App\Http\Controllers\Webhook\WebhookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::post('/webhook/{tenantId}', [WebhookController::class, 'handle'])
    ->name('webhook.handle')
    ->middleware('throttle:60,1');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
