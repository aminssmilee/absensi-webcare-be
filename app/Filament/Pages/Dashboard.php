<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use App\Filament\Widgets\StatsOverview;
use App\Filament\Widgets\AbsensiChart;
use App\Filament\Widgets\RecentAbsensi;
use Filament\Widgets\AccountWidget;

class Dashboard extends BaseDashboard
{
    public function getWidgets(): array
    {
        return [
            StatsOverview::class,
            // AbsensiChart::class,
            RecentAbsensi::class,
            // AccountWidget::class,
            
        ];
    }

    public function getColumns(): int|array
    {
        return 12;
    }
}
