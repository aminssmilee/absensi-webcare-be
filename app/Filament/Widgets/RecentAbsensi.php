<?php

namespace App\Filament\Widgets;

use App\Models\Absensi;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables;

class RecentAbsensi extends BaseWidget
{
    protected static ?string $heading = '📋 Absensi Terbaru';
    protected int | string | array $columnSpan = 'full'; // lebar penuh

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->query(
                Absensi::with('user')->latest()->take(5)
            )
            ->paginated(false)
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->label('Nama'),
                Tables\Columns\TextColumn::make('tanggal')->date()->label('Tanggal'),
                Tables\Columns\TextColumn::make('jam_masuk')->label('Jam Masuk'),
                Tables\Columns\TextColumn::make('jam_keluar')->label('Jam Keluar'),
            ]);
    }
}
