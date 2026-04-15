<?php

namespace App\Filament\Resources\WhatsappConnections\Pages;

use App\Filament\Resources\WhatsappConnections\WhatsappConnectionResource;
use App\Services\EvolutionApiService;
use Exception;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateWhatsappConnection extends CreateRecord
{
    protected static string $resource = WhatsappConnectionResource::class;

    public function mutateFormDataBeforeCreate(array $data): array
    {
        try {
            $service = new EvolutionApiService;

            // Generate a unique instance name
            $instanceName = $service->generateInstanceName('whatsapp');

            // Create the instance in Evolution API
            $response = $service->createInstance($instanceName, [
                'webhook_url' => route('api.webhook.whatsapp', absolute: true),
                'webhook_events' => [
                    'MESSAGES_UPSERT',
                    'MESSAGES_UPDATE',
                    'CONNECTION_UPDATE',
                ],
            ]);

            // Store the response data in the form data
            $data['instance_name'] = $response['instance']['instanceName'];
            $data['evolution_instance_id'] = $response['instance']['instanceId'];
            $data['api_key'] = $response['hash'];
            $data['status'] = $response['instance']['status'] ?? 'connecting';
            $data['team_id'] = auth()->user()->current_team_id;

        } catch (Exception $e) {
            Notification::make()
                ->title('Erro ao criar instância')
                ->body($e->getMessage())
                ->danger()
                ->send();

            throw $e;
        }

        return $data;
    }
}
