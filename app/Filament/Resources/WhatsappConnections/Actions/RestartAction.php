<?php

namespace App\Filament\Resources\WhatsappConnections\Actions;

use App\Models\WhatsappConnection;
use App\Services\EvolutionApiService;
use Exception;
use Filament\Actions\Action;
use Filament\Support\Icons\Heroicon;

class RestartAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'restart';
    }

    public static function make(?string $name = null): static
    {
        $name ??= static::getDefaultName();
        $action = parent::make($name);

        $action->label('Reiniciar')
            ->icon(Heroicon::OutlinedArrowPath)
            ->color('warning')
            ->requiresConfirmation()
            ->modalHeading('Reiniciar Conexão')
            ->modalDescription('Deseja reiniciar a conexão com o WhatsApp?')
            ->action(function (WhatsappConnection $record) {
                try {
                    $service = new EvolutionApiService;
                    $service->restartInstance($record->instance_name, $record->api_key);

                    $record->update(['status' => 'connecting']);

                    session()->flash('success', 'Conexão reiniciada com sucesso!');
                } catch (Exception $e) {
                    $record->update(['status' => 'error', 'error_message' => $e->getMessage()]);

                    session()->flash('error', 'Erro ao reiniciar: '.$e->getMessage());
                }
            })
            ->visible(fn (WhatsappConnection $record): bool => $record->isConnected());

        return $action;
    }
}
