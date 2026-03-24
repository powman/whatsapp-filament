<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WhatsappInstanceResource\Pages;
use App\Models\WhatsappInstance;
use App\Services\WhatsappInstanceService;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;

class WhatsappInstanceResource extends Resource
{
    protected static ?string $model = WhatsappInstance::class;

    protected static ?string $navigationIcon = 'heroicon-o-device-phone-mobile';

    protected static ?string $navigationLabel = 'Instâncias WhatsApp';

    protected static ?string $modelLabel = 'Instância WhatsApp';

    protected static ?string $pluralModelLabel = 'Instâncias WhatsApp';

    protected static ?string $navigationGroup = 'WhatsApp';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nome da Instância')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Ex: Suporte, Vendas, Marketing'),

                TextInput::make('webhook_url')
                    ->label('URL do Webhook (opcional)')
                    ->url()
                    ->placeholder('https://seu-sistema.com/webhook')
                    ->helperText('Deixe em branco para usar a URL padrão do sistema.'),

                Toggle::make('is_active')
                    ->label('Ativa')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->where('tenant_id', auth()->user()->tenant_id))
            ->columns([
                TextColumn::make('name')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('instance_name')
                    ->label('ID da Instância')
                    ->searchable()
                    ->copyable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('phone_number')
                    ->label('Número')
                    ->placeholder('Não conectado')
                    ->searchable(),

                BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'success' => 'connected',
                        'danger' => 'disconnected',
                        'warning' => 'qr_code',
                        'info' => 'connecting',
                        'gray' => 'unknown',
                    ])
                    ->icons([
                        'heroicon-o-check-circle' => 'connected',
                        'heroicon-o-x-circle' => 'disconnected',
                        'heroicon-o-qr-code' => 'qr_code',
                        'heroicon-o-arrow-path' => 'connecting',
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
                    ->sortable()
                    ->placeholder('Nunca'),

                TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'connected' => 'Conectado',
                        'disconnected' => 'Desconectado',
                        'qr_code' => 'Aguardando QR Code',
                        'connecting' => 'Conectando',
                    ]),
            ])
            ->actions([
                Action::make('connect')
                    ->label('Conectar')
                    ->icon('heroicon-o-wifi')
                    ->color('success')
                    ->visible(fn (WhatsappInstance $record): bool => $record->status !== 'connected')
                    ->action(function (WhatsappInstance $record): void {
                        try {
                            $service = app(WhatsappInstanceService::class);
                            $result = $service->connect($record);

                            if (isset($result['qr_code'])) {
                                Notification::make()
                                    ->title('QR Code Gerado')
                                    ->body('Escaneie o QR Code para conectar.')
                                    ->warning()
                                    ->send();
                            } else {
                                Notification::make()
                                    ->title('Conectando...')
                                    ->body('A instância está sendo conectada.')
                                    ->info()
                                    ->send();
                            }
                        } catch (GuzzleException $e) {
                            Notification::make()
                                ->title('Erro ao conectar')
                                ->body('Não foi possível conectar à instância: ' . $e->getMessage())
                                ->danger()
                                ->send();
                        }
                    }),

                Action::make('qrcode')
                    ->label('QR Code')
                    ->icon('heroicon-o-qr-code')
                    ->color('warning')
                    ->visible(fn (WhatsappInstance $record): bool => in_array($record->status, ['qr_code', 'disconnected']))
                    ->modalHeading('Escaneie o QR Code')
                    ->modalDescription('Abra o WhatsApp no seu celular e escaneie o código abaixo para conectar.')
                    ->modalContent(function (WhatsappInstance $record): HtmlString {
                        try {
                            $service = app(WhatsappInstanceService::class);
                            $result = $service->connect($record);
                            $qrCode = $result['qr_code'] ?? $record->qr_code;

                            if ($qrCode) {
                                return new HtmlString(
                                    '<div class="flex flex-col items-center gap-4 py-4">
                                        <img src="data:image/png;base64,' . $qrCode . '" alt="QR Code" class="w-64 h-64" />
                                        <p class="text-sm text-gray-500">O QR Code expira em alguns minutos. Atualize se necessário.</p>
                                    </div>'
                                );
                            }
                        } catch (\Exception $e) {
                            // Fall through to error message
                        }

                        return new HtmlString('<p class="text-center text-gray-500">Não foi possível gerar o QR Code. Tente novamente.</p>');
                    })
                    ->modalSubmitActionLabel('Fechar')
                    ->modalCancelAction(false),

                Action::make('disconnect')
                    ->label('Desconectar')
                    ->icon('heroicon-o-power')
                    ->color('danger')
                    ->visible(fn (WhatsappInstance $record): bool => $record->status === 'connected')
                    ->requiresConfirmation()
                    ->modalHeading('Desconectar instância?')
                    ->modalDescription('Tem certeza que deseja desconectar esta instância? O WhatsApp será deslogado.')
                    ->action(function (WhatsappInstance $record): void {
                        $service = app(WhatsappInstanceService::class);
                        $service->disconnect($record);

                        Notification::make()
                            ->title('Instância desconectada')
                            ->success()
                            ->send();
                    }),

                Action::make('refresh')
                    ->label('Atualizar Status')
                    ->icon('heroicon-o-arrow-path')
                    ->color('info')
                    ->action(function (WhatsappInstance $record): void {
                        try {
                            $service = app(WhatsappInstanceService::class);
                            $status = $service->refreshStatus($record);

                            Notification::make()
                                ->title('Status atualizado')
                                ->body("Status atual: {$status}")
                                ->success()
                                ->send();
                        } catch (GuzzleException $e) {
                            Notification::make()
                                ->title('Erro ao atualizar')
                                ->body($e->getMessage())
                                ->danger()
                                ->send();
                        }
                    }),

                Tables\Actions\EditAction::make(),

                Tables\Actions\DeleteAction::make()
                    ->before(function (WhatsappInstance $record): void {
                        $service = app(WhatsappInstanceService::class);
                        $service->delete($record);
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Nenhuma instância cadastrada')
            ->emptyStateDescription('Crie sua primeira instância WhatsApp para começar.')
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWhatsappInstances::route('/'),
            'create' => Pages\CreateWhatsappInstance::route('/create'),
            'edit' => Pages\EditWhatsappInstance::route('/{record}/edit'),
        ];
    }
}
