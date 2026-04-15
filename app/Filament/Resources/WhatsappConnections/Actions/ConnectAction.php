<?php

namespace App\Filament\Resources\WhatsappConnections\Actions;

use App\Models\WhatsappConnection;
use App\Services\EvolutionApiService;
use Exception;
use Filament\Actions\Action;
use Filament\Support\Icons\Heroicon;

class ConnectAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'connect';
    }

    public static function make(?string $name = null): static
    {
        $name ??= static::getDefaultName();
        $action = parent::make($name);

        $action->label('Conectar')
            ->icon(Heroicon::OutlinedCheckCircle)
            ->color('success')
            ->requiresConfirmation()
            ->modalHeading('Conectar ao WhatsApp')
            ->modalDescription('Escaneie o código QR abaixo com o seu telefone para conectar este número ao WhatsApp.')
            ->modalIcon(Heroicon::OutlinedCheckCircle)
            ->action(function (WhatsappConnection $record) {
                try {
                    $service = new EvolutionApiService;
                    $response = $service->getConnectionCode($record->instance_name, $record->api_key);

                    if (isset($response['base64']) && ! isset($response['instance'])) {
                        // Not connected yet, show QR code
                        $record->update(['status' => 'connecting']);

                        session()->put('qr_code_'.$record->id, $response['base64']);
                        session()->put('qr_code_data_'.$record->id, json_encode($response));

                        redirect()->route('filament.admin.resources.whatsapp-connections.show-qr-code', ['record' => $record->id]);
                    } else {
                        // Already connected
                        $record->update(['status' => 'connected']);

                        session()->flash('success', 'Conexão já estabelecida!');
                        redirect()->route('filament.admin.resources.whatsapp-connections.index');
                    }
                } catch (Exception $e) {
                    $record->update(['status' => 'error', 'error_message' => $e->getMessage()]);

                    session()->flash('error', 'Erro ao conectar: '.$e->getMessage());
                }
            })
            ->visible(fn (WhatsappConnection $record): bool => $record->isDisconnected() || $record->hasError());

        return $action;
    }
}
