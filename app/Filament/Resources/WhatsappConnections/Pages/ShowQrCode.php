<?php

namespace App\Filament\Resources\WhatsappConnections\Pages;

use App\Filament\Resources\WhatsappConnections\WhatsappConnectionResource;
use App\Models\WhatsappConnection;
use Filament\Resources\Pages\Page;

class ShowQrCode extends Page
{
    protected static string $resource = WhatsappConnectionResource::class;

    protected string $view = 'filament.resources.whatsapp-connections.pages.show-qr-code';

    public WhatsappConnection $record;

    public ?string $qrCode = null;

    public function mount(): void
    {
        $this->qrCode = session()->get('qr_code_'.$this->record->id);
    }
}
