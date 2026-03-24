<?php

namespace App\Http\Controllers\Webhook;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessWebhookJob;
use App\Models\Tenant;
use App\Models\WebhookLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function handle(Request $request, int $tenantId): JsonResponse
    {
        $tenant = Tenant::find($tenantId);

        if (! $tenant || ! $tenant->is_active) {
            return response()->json(['error' => 'Tenant not found'], 404);
        }

        $payload = $request->all();
        $event = $payload['event'] ?? 'unknown';
        $instanceName = $payload['instance'] ?? null;

        $log = WebhookLog::create([
            'tenant_id' => $tenantId,
            'whatsapp_instance_id' => null,
            'event' => $event,
            'payload' => $payload,
            'status' => 'pending',
        ]);

        dispatch(new ProcessWebhookJob($log->id));

        Log::info('Webhook received', [
            'tenant_id' => $tenantId,
            'event' => $event,
            'instance' => $instanceName,
        ]);

        return response()->json(['status' => 'received']);
    }
}
