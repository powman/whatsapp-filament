<?php

namespace App\Filament\Resources\WhatsappConnections\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class WhatsappConnectionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Configuração Básica')
                    ->description('Configure as informações básicas da sua conexão WhatsApp')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('instance_name')
                                    ->label('Nome da Instância')
                                    ->placeholder('ex: minha-conexao')
                                    ->disabled()
                                    ->dehydrated()
                                    ->helperText('Gerado automaticamente pela Evolution API'),

                                TextInput::make('phone_number')
                                    ->label('Número do Telefone')
                                    ->placeholder('ex: +5511999999999')
                                    ->disabled(fn ($operation) => $operation === 'edit')
                                    ->dehydrated()
                                    ->helperText('Número associado a esta conexão'),
                            ]),

                        Grid::make(2)
                            ->schema([
                                TextInput::make('profile_name')
                                    ->label('Nome do Perfil')
                                    ->disabled(fn ($operation) => $operation === 'edit')
                                    ->dehydrated()
                                    ->helperText('Nome do perfil WhatsApp'),

                                Select::make('status')
                                    ->label('Status')
                                    ->options([
                                        'disconnected' => 'Desconectado',
                                        'connecting' => 'Conectando',
                                        'connected' => 'Conectado',
                                        'error' => 'Erro',
                                    ])
                                    ->disabled()
                                    ->dehydrated(),
                            ]),
                    ]),

                Section::make('Configurações de Comportamento')
                    ->description('Configure como a instância se comportará no WhatsApp')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Toggle::make('reject_calls')
                                    ->label('Rejeitar Chamadas')
                                    ->helperText('Rejeitar automaticamente chamadas recebidas'),

                                Toggle::make('groups_ignore')
                                    ->label('Ignorar Mensagens de Grupos')
                                    ->helperText('Não processar mensagens de grupos'),
                            ]),

                        Grid::make(2)
                            ->schema([
                                Toggle::make('always_online')
                                    ->label('Sempre Online')
                                    ->helperText('Exibir sempre como online'),

                                Toggle::make('read_messages')
                                    ->label('Ler Mensagens Automaticamente')
                                    ->helperText('Marcar mensagens como lidas automaticamente'),
                            ]),
                    ]),

                Section::make('Informações Avançadas')
                    ->schema([
                        TextInput::make('created_at')
                            ->label('Criado em')
                            ->disabled()
                            ->dehydrated()
                            ->formatStateUsing(fn ($state): string => $state instanceof \DateTime ? $state->format('d/m/Y H:i:s') : '-'),

                        TextInput::make('last_sync_at')
                            ->label('Última Sincronização')
                            ->disabled()
                            ->dehydrated()
                            ->formatStateUsing(fn ($state): string => $state instanceof \DateTime ? $state->format('d/m/Y H:i:s') : 'Nunca'),

                        TextInput::make('connected_at')
                            ->label('Conectado em')
                            ->disabled()
                            ->dehydrated()
                            ->formatStateUsing(fn ($state): string => $state instanceof \DateTime ? $state->format('d/m/Y H:i:s') : '-'),
                    ])
                    ->collapsed()
                    ->visible(fn ($record): bool => $record !== null),
            ]);
    }
}
