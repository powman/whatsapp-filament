<?php

namespace App\Filament\Resources\WhatsappConnections\Actions;

use App\Models\WhatsappConnection;
use App\Services\EvolutionApiService;
use Exception;
use Filament\Actions\Action;
use Filament\Support\Icons\Heroicon;

class LogoutAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'logout';
    }

    public static function make(?string $name = null): static
    {
        $name ??= static::getDefaultName();
        $action = parent::make($name);

        $action->label('Desconectar')
            ->icon(Heroicon::OutlinedArrowRightOnRectangle)
            ->color('danger')
            ->requiresConfirmation()
            ->modalHeading('Desconectar WhatsApp')
            ->modalDescription('Deseja desconectar este número do WhatsApp? A configuração será mantida.')
            ->action(function (WhatsappConnection $record) {
                try {
                    $service = new EvolutionApiService;
                    $service->logoutInstance($record->instance_name, $record->api_key);

                    $record->update([
                        'status' => 'disconnected',
                        'phone_number' => null,
                        'profile_name' => null,
                        'profile_pic_url' => null,
                        'connected_at' => null,
                    ]);

                    session()->flash('success', 'Desconectado com sucesso!');
                } catch (Exception $e) {
                    $record->update(['status' => 'error', 'error_message' => $e->getMessage()]);

                    session()->flash('error', 'Erro ao desconectar: '.$e->getMessage());
                }
            })
            ->visible(fn (WhatsappConnection $record): bool => $record->isConnected());

        return $action;
    }
}
