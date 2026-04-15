<?php

namespace App\Filament\Resources\WhatsappConnections\Pages;

use App\Filament\Resources\WhatsappConnections\WhatsappConnectionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListWhatsappConnections extends ListRecords
{
    protected static string $resource = WhatsappConnectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
