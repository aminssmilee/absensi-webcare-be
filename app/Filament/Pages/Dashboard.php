<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use App\Filament\Widgets\StatsOverview;
use App\Filament\Widgets\AbsensiCard;
use App\Filament\Widgets\RecentAbsensi;
use Filament\Widgets\AccountWidget;
use App\Filament\Widgets\AbsensiSudahWidget;
use App\Filament\Widgets\AbsensiBelumWidget;
use App\Models\Absensi;

class Dashboard extends BaseDashboard
{
    public function getWidgets(): array
    {
        return [
            StatsOverview::class,
            // AbsensiSudahWidget::class,
            // AbsensiBelumWidget::class,
            AbsensiCard::class,
            RecentAbsensi::class,
            // AccountWidget::class,

        ];
    }

    public function getColumns(): int|array
    {
        return 12;
    }
}
