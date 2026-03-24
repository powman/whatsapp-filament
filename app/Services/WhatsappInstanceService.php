<?php

namespace App\Services;

use App\DTOs\EvolutionInstanceDTO;
use App\Models\WhatsappInstance;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class WhatsappInstanceService
{
    public function __construct(
        private readonly EvolutionApiService $evolutionApi
    ) {}

    /**
     * Create a new instance locally and on Evolution API.
     */
    public function create(int $tenantId, string $name, ?string $webhookUrl = null): WhatsappInstance
    {
        $instanceName = Str::slug($name) . '-' . Str::random(8);

        $instance = WhatsappInstance::create([
            'tenant_id' => $tenantId,
            'name' => $name,
            'instance_name' => $instanceName,
            'status' => 'disconnected',
            'webhook_url' => $webhookUrl,
        ]);

        try {
            $dto = new EvolutionInstanceDTO(
                instanceName: $instanceName,
                qrcode: true,
                webhookUrl: $webhookUrl ?? url("/api/webhook/{$tenantId}"),
            );

            $response = $this->evolutionApi->createInstance($dto);

            Log::info('Instance created on Evolution API', [
                'instance_id' => $instance->id,
                'response' => $response,
            ]);
        } catch (GuzzleException $e) {
            Log::warning('Failed to create instance on Evolution API', [
                'instance_id' => $instance->id,
                'error' => $e->getMessage(),
            ]);
        }

        return $instance;
    }

    /**
     * Connect instance and get QR code.
     */
    public function connect(WhatsappInstance $instance): array
    {
        try {
            $response = $this->evolutionApi->connectInstance($instance->instance_name);

            if (isset($response['qrcode']) || isset($response['base64'])) {
                $qrCode = $response['base64'] ?? $response['qrcode']['base64'] ?? null;

                $instance->update([
                    'status' => 'qr_code',
                    'qr_code' => $qrCode,
                    'last_status_at' => now(),
                ]);

                Cache::put("instance_status_{$instance->id}", 'qr_code', now()->addMinutes(5));

                return [
                    'status' => 'qr_code',
                    'qr_code' => $qrCode,
                ];
            }

            if (isset($response['instance']['state'])) {
                $status = $this->mapEvolutionStatus($response['instance']['state']);
                $instance->updateStatus($status);

                return ['status' => $status];
            }

            return $response;
        } catch (GuzzleException $e) {
            Log::error('Failed to connect instance', [
                'instance_id' => $instance->id,
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    /**
     * Disconnect instance.
     */
    public function disconnect(WhatsappInstance $instance): bool
    {
        try {
            $this->evolutionApi->disconnectInstance($instance->instance_name);
            $instance->updateStatus('disconnected');

            return true;
        } catch (GuzzleException $e) {
            Log::error('Failed to disconnect instance', [
                'instance_id' => $instance->id,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    /**
     * Delete instance locally and on Evolution API.
     */
    public function delete(WhatsappInstance $instance): void
    {
        try {
            $this->evolutionApi->deleteInstance($instance->instance_name);
        } catch (GuzzleException $e) {
            Log::warning('Failed to delete instance on Evolution API', [
                'instance_id' => $instance->id,
                'error' => $e->getMessage(),
            ]);
        }

        Cache::forget("instance_status_{$instance->id}");
        $instance->delete();
    }

    /**
     * Refresh status from Evolution API.
     */
    public function refreshStatus(WhatsappInstance $instance): string
    {
        try {
            $response = $this->evolutionApi->getConnectionState($instance->instance_name);
            $evolutionStatus = $response['instance']['state'] ?? 'close';
            $status = $this->mapEvolutionStatus($evolutionStatus);
            $instance->updateStatus($status);

            return $status;
        } catch (GuzzleException $e) {
            Log::error('Failed to refresh instance status', [
                'instance_id' => $instance->id,
                'error' => $e->getMessage(),
            ]);

            return $instance->status;
        }
    }

    /**
     * Map Evolution API status to our internal status.
     */
    public function mapEvolutionStatus(string $evolutionStatus): string
    {
        return match (strtolower($evolutionStatus)) {
            'open' => 'connected',
            'close', 'closed' => 'disconnected',
            'connecting' => 'connecting',
            'qr' => 'qr_code',
            default => 'unknown',
        };
    }
}
