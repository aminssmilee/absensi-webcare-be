<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Absensi;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';

    protected function getCards(): array
    {
        return [
            Card::make('Jumlah Karyawan', User::count())
                ->description('Total Karyawan')
                ->descriptionIcon('heroicon-o-users')
                ->color('primary'),

            Card::make('Absensi Hari Ini', Absensi::whereDate('tanggal', today())->count())
                ->description('Total absensi hari ini')
                ->descriptionIcon('heroicon-o-clipboard-document-check')
                ->color('success'),

            // 🔹 tambahan fitur baru
            Card::make(
                'Belum Absen',
                User::count() - Absensi::whereDate('tanggal', today())->distinct('user_id')->count('user_id')
            )
                ->description('Karyawan yang belum absen')
                ->descriptionIcon('heroicon-o-exclamation-circle')
                ->color('danger'),
        ];
    }
}
