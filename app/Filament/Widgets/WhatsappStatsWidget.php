<?php

namespace App\Filament\Widgets;

use App\Models\WhatsappInstance;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class WhatsappStatsWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $tenantId = auth()->user()->tenant_id;

        $total = WhatsappInstance::where('tenant_id', $tenantId)->count();
        $connected = WhatsappInstance::where('tenant_id', $tenantId)
            ->where('status', 'connected')
            ->count();
        $disconnected = WhatsappInstance::where('tenant_id', $tenantId)
            ->where('status', 'disconnected')
            ->count();
        $waitingQr = WhatsappInstance::where('tenant_id', $tenantId)
            ->where('status', 'qr_code')
            ->count();

        return [
            Stat::make('Total de Conexões', $total)
                ->description('Todas as instâncias')
                ->descriptionIcon('heroicon-o-device-phone-mobile')
                ->color('primary'),

            Stat::make('Conexões Ativas', $connected)
                ->description('Instâncias conectadas')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('success'),

            Stat::make('Aguardando QR Code', $waitingQr)
                ->description('Precisam de configuração')
                ->descriptionIcon('heroicon-o-qr-code')
                ->color('warning'),

            Stat::make('Desconectadas', $disconnected)
                ->description('Instâncias offline')
                ->descriptionIcon('heroicon-o-x-circle')
                ->color('danger'),
        ];
    }
}
