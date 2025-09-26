<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables;

class AbsensiBelumWidget extends BaseWidget
{
    protected static ?string $heading = '❌ Belum Absen Hari Ini';
    protected int | string | array $columnSpan = 'full'; // setengah lebar dashboard

    public function table(Tables\Table $table): Tables\Table
    {
        $hariIni = now()->toDateString();

        return $table
            ->query(
                User::whereDoesntHave('absensis', function ($q) use ($hariIni) {
                    $q->whereDate('tanggal', $hariIni);
                })
            )
            ->paginated(false)
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nama'),
            ]);
    }
}
