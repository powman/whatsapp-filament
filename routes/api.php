<?php

use Illuminate\Support\Facades\Route;

Route::post('/webhook/whatsapp', function () {
    // Webhook handler for Evolution API WhatsApp events
    // This endpoint receives connection updates, messages, and other events
    return response()->json(['status' => 'ok']);
})->name('api.webhook.whatsapp');
