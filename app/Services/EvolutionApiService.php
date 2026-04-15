<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class EvolutionApiService
{
    private string $baseUrl;

    private string $globalApiKey;

    public function __construct()
    {
        $this->baseUrl = config('services.evolution_api.base_url', 'http://localhost:8080');
        $this->globalApiKey = config('services.evolution_api.global_api_key', '');
    }

    /**
     * Check if using mock mode (no API key configured).
     */
    private function isUsingMockMode(): bool
    {
        return empty($this->globalApiKey);
    }

    /**
     * Create a new WhatsApp instance.
     *
     * @throws Exception
     */
    public function createInstance(string $instanceName, array $options = []): array
    {
        // Mock mode for development without API key
        if ($this->isUsingMockMode()) {
            return $this->createInstanceMock($instanceName);
        }

        $payload = array_merge([
            'instanceName' => $instanceName,
            'integration' => 'WHATSAPP-BAILEYS',
            'qrcode' => true,
            'rejectCall' => $options['rejectCall'] ?? true,
            'msgCall' => $options['msgCall'] ?? 'Sorry, I cannot take calls right now',
            'groupsIgnore' => $options['groupsIgnore'] ?? false,
            'alwaysOnline' => $options['alwaysOnline'] ?? true,
            'readMessages' => $options['readMessages'] ?? false,
            'readStatus' => $options['readStatus'] ?? false,
            'syncFullHistory' => $options['syncFullHistory'] ?? false,
        ], $options);

        if (isset($options['webhook_url'])) {
            $payload['webhook'] = [
                'enabled' => true,
                'url' => $options['webhook_url'],
                'byEvents' => false,
                'base64' => true,
                'events' => $options['webhook_events'] ?? [
                    'MESSAGES_UPSERT',
                    'MESSAGES_UPDATE',
                    'CONNECTION_UPDATE',
                ],
            ];
        }

        $response = Http::post("{$this->baseUrl}/instance/create", $payload);

        if (! $response->successful()) {
            throw new Exception("Failed to create instance: {$response->body()}");
        }

        return $response->json();
    }

    /**
     * Mock response for creating instance in development mode.
     */
    private function createInstanceMock(string $instanceName): array
    {
        return [
            'instance' => [
                'instanceId' => Str::uuid(),
                'instanceName' => $instanceName,
                'status' => 'connecting',
            ],
            'hash' => Str::random(64),
        ];
    }

    /**
     * Get connection QR code or pairing code.
     *
     * @throws Exception
     */
    public function getConnectionCode(string $instanceName, string $apiKey): array
    {
        // Mock mode for development
        if ($this->isUsingMockMode()) {
            return [
                'qrcode' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==',
                'base64' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==',
            ];
        }

        $response = Http::withHeaders([
            'apikey' => $apiKey,
        ])->get("{$this->baseUrl}/instance/connect/{$instanceName}");

        if (! $response->successful()) {
            throw new Exception("Failed to get connection code: {$response->body()}");
        }

        return $response->json();
    }

    /**
     * Fetch all instances or filter by specific criteria.
     *
     * @throws Exception
     */
    public function fetchInstances(array $filters = []): array
    {
        $query = '';
        if (! empty($filters['instanceName'])) {
            $query .= "?instanceName={$filters['instanceName']}";
        } elseif (! empty($filters['phoneNumber'])) {
            $query .= "?phoneNumber={$filters['phoneNumber']}";
        }

        $response = Http::withHeaders([
            'apikey' => $this->globalApiKey,
        ])->get("{$this->baseUrl}/instance/fetchInstances{$query}");

        if (! $response->successful()) {
            throw new Exception("Failed to fetch instances: {$response->body()}");
        }

        return $response->json();
    }

    /**
     * Fetch a specific instance.
     *
     * @throws Exception
     */
    public function fetchInstance(string $instanceName, string $apiKey): array
    {
        $response = Http::withHeaders([
            'apikey' => $apiKey,
        ])->get("{$this->baseUrl}/instance/fetchInstances?instanceName={$instanceName}");

        if (! $response->successful()) {
            throw new Exception("Failed to fetch instance: {$response->body()}");
        }

        $instances = $response->json();

        if (empty($instances)) {
            throw new Exception("Instance not found: {$instanceName}");
        }

        return $instances[0];
    }

    /**
     * Restart a WhatsApp instance connection.
     *
     * @throws Exception
     */
    public function restartInstance(string $instanceName, string $apiKey): array
    {
        // Mock mode for development
        if ($this->isUsingMockMode()) {
            return ['message' => 'Instance restarted successfully'];
        }

        $response = Http::withHeaders([
            'apikey' => $apiKey,
        ])->put("{$this->baseUrl}/instance/restart/{$instanceName}");

        if (! $response->successful()) {
            throw new Exception("Failed to restart instance: {$response->body()}");
        }

        return $response->json();
    }

    /**
     * Logout a WhatsApp instance.
     *
     * @throws Exception
     */
    public function logoutInstance(string $instanceName, string $apiKey): array
    {
        // Mock mode for development
        if ($this->isUsingMockMode()) {
            return ['message' => 'Instance logged out successfully'];
        }

        $response = Http::withHeaders([
            'apikey' => $apiKey,
        ])->delete("{$this->baseUrl}/instance/logout/{$instanceName}");

        if (! $response->successful()) {
            throw new Exception("Failed to logout instance: {$response->body()}");
        }

        return $response->json();
    }

    /**
     * Delete a WhatsApp instance.
     *
     * @throws Exception
     */
    public function deleteInstance(string $instanceName, string $apiKey): array
    {
        // Mock mode for development
        if ($this->isUsingMockMode()) {
            return ['message' => 'Instance deleted successfully'];
        }

        $response = Http::withHeaders([
            'apikey' => $apiKey,
        ])->delete("{$this->baseUrl}/instance/delete/{$instanceName}");

        if (! $response->successful()) {
            throw new Exception("Failed to delete instance: {$response->body()}");
        }

        return $response->json();
    }

    /**
     * Generate a unique instance name.
     */
    public function generateInstanceName(string $baseName = 'instance'): string
    {
        $slug = Str::slug($baseName);

        return "{$slug}-".Str::random(8);
    }
}
