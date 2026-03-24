<?php

namespace App\Filament\Resources\WhatsappInstanceResource\Pages;

use App\Filament\Resources\WhatsappInstanceResource;
use App\Services\WhatsappInstanceService;
use Filament\Resources\Pages\CreateRecord;

class CreateWhatsappInstance extends CreateRecord
{
    protected static string $resource = WhatsappInstanceResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['tenant_id'] = auth()->user()->tenant_id;

        return $data;
    }

    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        $service = app(WhatsappInstanceService::class);

        return $service->create(
            tenantId: $data['tenant_id'],
            name: $data['name'],
            webhookUrl: $data['webhook_url'] ?? null,
        );
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
