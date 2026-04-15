<?php

namespace App\Filament\Resources\WhatsappConnections;

use App\Filament\Resources\WhatsappConnections\Pages\CreateWhatsappConnection;
use App\Filament\Resources\WhatsappConnections\Pages\EditWhatsappConnection;
use App\Filament\Resources\WhatsappConnections\Pages\ListWhatsappConnections;
use App\Filament\Resources\WhatsappConnections\Pages\ShowQrCode;
use App\Filament\Resources\WhatsappConnections\Schemas\WhatsappConnectionForm;
use App\Filament\Resources\WhatsappConnections\Tables\WhatsappConnectionsTable;
use App\Models\WhatsappConnection;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class WhatsappConnectionResource extends Resource
{
    protected static ?string $model = WhatsappConnection::class;

    protected static ?string $navigationLabel = 'Conexões WhatsApp';

    protected static ?string $modelLabel = 'Conexão WhatsApp';

    protected static ?string $pluralModelLabel = 'Conexões WhatsApp';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Check;

    protected static string|UnitEnum|null $navigationGroup = 'WhatsApp';

    public static function form(Schema $schema): Schema
    {
        return WhatsappConnectionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WhatsappConnectionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListWhatsappConnections::route('/'),
            'create' => CreateWhatsappConnection::route('/create'),
            'edit' => EditWhatsappConnection::route('/{record}/edit'),
            'show-qr-code' => ShowQrCode::route('/{record}/qr-code'),
        ];
    }
}
