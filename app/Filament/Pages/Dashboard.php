<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\RecentInstancesWidget;
use App\Filament\Widgets\WhatsappStatsWidget;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static ?string $title = 'Dashboard';

    public function getWidgets(): array
    {
        return [
            WhatsappStatsWidget::class,
            RecentInstancesWidget::class,
        ];
    }

    public function getColumns(): int|string|array
    {
        return 2;
    }
}
