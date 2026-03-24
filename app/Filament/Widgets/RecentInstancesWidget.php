<?php

namespace App\Filament\Widgets;

use App\Models\WhatsappInstance;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class RecentInstancesWidget extends BaseWidget
{
    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    protected static ?string $heading = 'Instâncias Recentes';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                WhatsappInstance::query()
                    ->where('tenant_id', auth()->user()->tenant_id)
                    ->latest()
                    ->limit(5)
            )
            ->columns([
                TextColumn::make('name')
                    ->label('Nome'),

                BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'success' => 'connected',
                        'danger' => 'disconnected',
                        'warning' => 'qr_code',
                        'info' => 'connecting',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'connected' => 'Conectado',
                        'disconnected' => 'Desconectado',
                        'qr_code' => 'Aguardando QR Code',
                        'connecting' => 'Conectando...',
                        default => 'Desconhecido',
                    }),

                TextColumn::make('last_status_at')
                    ->label('Última Atualização')
                    ->dateTime('d/m/Y H:i')
                    ->placeholder('Nunca'),
            ]);
    }
}
