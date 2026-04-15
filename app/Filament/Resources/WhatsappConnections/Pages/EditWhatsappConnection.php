<?php

namespace App\Filament\Resources\WhatsappConnections\Pages;

use App\Filament\Resources\WhatsappConnections\Actions\ConnectAction;
use App\Filament\Resources\WhatsappConnections\Actions\LogoutAction;
use App\Filament\Resources\WhatsappConnections\Actions\RestartAction;
use App\Filament\Resources\WhatsappConnections\WhatsappConnectionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditWhatsappConnection extends EditRecord
{
    protected static string $resource = WhatsappConnectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ConnectAction::make(),
            RestartAction::make(),
            LogoutAction::make(),
            DeleteAction::make(),
        ];
    }
}
