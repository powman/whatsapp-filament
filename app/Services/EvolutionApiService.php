<?php

namespace App\Services;

use App\DTOs\EvolutionInstanceDTO;
use App\DTOs\EvolutionMessageDTO;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class EvolutionApiService
{
    private Client $client;

    private string $baseUrl;

    private string $apiKey;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('services.evolution.base_url', env('EVOLUTION_API_BASE_URL', 'http://localhost:8080')), '/');
        $this->apiKey = config('services.evolution.api_key', env('EVOLUTION_API_KEY', ''));

        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'timeout' => 30,
            'headers' => [
                'Content-Type' => 'application/json',
                'apikey' => $this->apiKey,
            ],
        ]);
    }

    /**
     * Create a new WhatsApp instance on Evolution API.
     */
    public function createInstance(EvolutionInstanceDTO $dto): array
    {
        return $this->request('POST', '/instance/create', $dto->toArray());
    }

    /**
     * Get connection status of an instance.
     */
    public function getConnectionState(string $instanceName): array
    {
        return $this->request('GET', "/instance/connectionState/{$instanceName}");
    }

    /**
     * Connect an instance (returns QR code data if not connected).
     */
    public function connectInstance(string $instanceName): array
    {
        return $this->request('GET', "/instance/connect/{$instanceName}");
    }

    /**
     * Disconnect (logout) an instance.
     */
    public function disconnectInstance(string $instanceName): array
    {
        return $this->request('DELETE', "/instance/logout/{$instanceName}");
    }

    /**
     * Delete an instance from Evolution API.
     */
    public function deleteInstance(string $instanceName): array
    {
        return $this->request('DELETE', "/instance/delete/{$instanceName}");
    }

    /**
     * Restart an instance.
     */
    public function restartInstance(string $instanceName): array
    {
        return $this->request('POST', "/instance/restart/{$instanceName}");
    }

    /**
     * Fetch QR code for an instance.
     */
    public function fetchQrCode(string $instanceName): array
    {
        return $this->request('GET', "/instance/qrcode/{$instanceName}");
    }

    /**
     * Send a text message.
     */
    public function sendTextMessage(string $instanceName, EvolutionMessageDTO $dto): array
    {
        return $this->request('POST', "/message/sendText/{$instanceName}", $dto->toArray());
    }

    /**
     * Get all instances.
     */
    public function fetchInstances(): array
    {
        return $this->request('GET', '/instance/fetchInstances');
    }

    /**
     * Set webhook configuration for an instance.
     */
    public function setWebhook(string $instanceName, string $webhookUrl, array $events = []): array
    {
        return $this->request('POST', "/webhook/set/{$instanceName}", [
            'url' => $webhookUrl,
            'byEvents' => true,
            'base64' => false,
            'events' => $events ?: $this->getDefaultEvents(),
        ]);
    }

    /**
     * Get default webhook events.
     */
    private function getDefaultEvents(): array
    {
        return [
            'APPLICATION_STARTUP',
            'QRCODE_UPDATED',
            'MESSAGES_SET',
            'MESSAGES_UPSERT',
            'MESSAGES_UPDATE',
            'MESSAGES_DELETE',
            'SEND_MESSAGE',
            'CONTACTS_SET',
            'CONTACTS_UPSERT',
            'CONTACTS_UPDATE',
            'PRESENCE_UPDATE',
            'CHATS_SET',
            'CHATS_UPSERT',
            'CHATS_UPDATE',
            'CHATS_DELETE',
            'GROUPS_UPSERT',
            'GROUPS_UPDATE',
            'GROUP_PARTICIPANTS_UPDATE',
            'CONNECTION_UPDATE',
            'CALL',
            'NEW_JWT_TOKEN',
        ];
    }

    /**
     * Make an HTTP request to Evolution API.
     */
    private function request(string $method, string $path, array $data = []): array
    {
        try {
            $options = [];

            if (! empty($data) && in_array($method, ['POST', 'PUT', 'PATCH'])) {
                $options['json'] = $data;
            }

            $response = $this->client->request($method, $path, $options);
            $body = (string) $response->getBody();

            return json_decode($body, true) ?? [];
        } catch (GuzzleException $e) {
            Log::error('Evolution API request failed', [
                'method' => $method,
                'path' => $path,
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }
}
