<?php

namespace App\Filament\Resources\WhatsappConnections\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class WhatsappConnectionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('instance_name')
                    ->label('Nome da Instância')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('phone_number')
                    ->label('Número')
                    ->placeholder('-')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('profile_name')
                    ->label('Perfil')
                    ->placeholder('-')
                    ->searchable(),

                BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'success' => 'connected',
                        'warning' => 'connecting',
                        'danger' => fn ($state): bool => $state === 'error' || $state === 'disconnected',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'connected' => 'Conectado',
                        'connecting' => 'Conectando',
                        'disconnected' => 'Desconectado',
                        'error' => 'Erro',
                        default => $state,
                    })
                    ->sortable(),

                TextColumn::make('connected_at')
                    ->label('Conectado em')
                    ->dateTime('d/m/Y H:i')
                    ->placeholder('-')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'connected' => 'Conectado',
                        'connecting' => 'Conectando',
                        'disconnected' => 'Desconectado',
                        'error' => 'Erro',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
