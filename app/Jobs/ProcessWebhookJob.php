<?php

namespace App\Jobs;

use App\Models\WebhookLog;
use App\Models\WhatsappInstance;
use App\Services\WhatsappInstanceService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessWebhookJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $tries = 3;

    public int $timeout = 60;

    public function __construct(
        private readonly int $webhookLogId
    ) {}

    public function handle(WhatsappInstanceService $instanceService): void
    {
        $log = WebhookLog::find($this->webhookLogId);

        if (! $log) {
            return;
        }

        try {
            $this->processEvent($log, $instanceService);
            $log->markAsProcessed();
        } catch (\Exception $e) {
            Log::error('Failed to process webhook', [
                'log_id' => $log->id,
                'error' => $e->getMessage(),
            ]);
            $log->markAsFailed($e->getMessage());
        }
    }

    private function processEvent(WebhookLog $log, WhatsappInstanceService $instanceService): void
    {
        $event = $log->event;
        $payload = $log->payload;
        $instanceName = $payload['instance'] ?? null;

        if (! $instanceName) {
            return;
        }

        $instance = WhatsappInstance::where('instance_name', $instanceName)
            ->where('tenant_id', $log->tenant_id)
            ->first();

        if ($instance) {
            $log->update(['whatsapp_instance_id' => $instance->id]);
        }

        match ($event) {
            'CONNECTION_UPDATE' => $this->handleConnectionUpdate($instance, $payload, $instanceService),
            'QRCODE_UPDATED' => $this->handleQrCodeUpdate($instance, $payload),
            default => Log::info('Unhandled webhook event', ['event' => $event]),
        };
    }

    private function handleConnectionUpdate(?WhatsappInstance $instance, array $payload, WhatsappInstanceService $instanceService): void
    {
        if (! $instance) {
            return;
        }

        $state = $payload['data']['state'] ?? null;

        if ($state) {
            $status = $instanceService->mapEvolutionStatus($state);
            $instance->updateStatus($status);

            Log::info('Instance status updated from webhook', [
                'instance_id' => $instance->id,
                'status' => $status,
            ]);
        }
    }

    private function handleQrCodeUpdate(?WhatsappInstance $instance, array $payload): void
    {
        if (! $instance) {
            return;
        }

        $qrCode = $payload['data']['qrcode']['base64'] ?? $payload['data']['base64'] ?? null;

        if ($qrCode) {
            $instance->update([
                'status' => 'qr_code',
                'qr_code' => $qrCode,
                'last_status_at' => now(),
            ]);
        }
    }
}
