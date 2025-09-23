<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AbsensiResource\Pages;
use App\Models\Absensi;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Illuminate\Support\Carbon;

class AbsensiResource extends Resource
{
    protected static ?string $model = Absensi::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'History Absensi';

    protected function getActions(): array
    {
        return [];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->label('Nama'),
                Tables\Columns\TextColumn::make('tanggal')->date()->label('Tanggal'),
                Tables\Columns\TextColumn::make('jam_masuk')->label('Jam Masuk'),
                Tables\Columns\TextColumn::make('jam_keluar')->label('Jam Keluar'),

                // 🔹 Tambahkan kolom Status (Masuk, Keluar, Izin)
                Tables\Columns\BadgeColumn::make('type')
                    ->label('Status')
                    ->colors([
                        'success' => 'Masuk',
                        'danger'  => 'Keluar',
                        'warning' => 'Izin',
                    ])
                    ->sortable(),

                // 🔹 Tambahkan kolom Deskripsi Izin
                Tables\Columns\TextColumn::make('deskripsi')
                    ->label('Keterangan Izin')
                    ->limit(40)
                    ->wrap()
                    ->toggleable(isToggledHiddenByDefault: true),

                // 🔹 Kolom Lokasi (tetap sesuai kode lama)
                Tables\Columns\TextColumn::make('aksi')
                    ->label('Lokasi')
                    ->html()
                    ->alignment('center') 
                    ->view('tables.columns.aksi')
                    ->state(fn($record) => 'aksi')
                    ->formatStateUsing(function ($record) {
                        $buttons = '<div class="flex gap-2">';

                        if ($record->lokasi_masuk) {
                            $buttons .= '<a href="https://www.google.com/maps?q=' . urlencode($record->lokasi_masuk) . '" 
                target="_blank"
                class="px-3 py-1 text-sm rounded-md border border-blue-500 bg-blue-500 text-white font-medium hover:bg-blue-600 hover:text-white">
                Lokasi Masuk</a>';
                        }

                        if ($record->lokasi_keluar) {
                            $buttons .= '<a href="https://www.google.com/maps?q=' . urlencode($record->lokasi_keluar) . '" 
                target="_blank"
                class="px-3 py-1 text-sm rounded-md border border-green-500 bg-green-500 text-white font-medium hover:bg-green-600 hover:text-white">
                Lokasi Keluar</a>';
                        }

                        $buttons .= '</div>';

                        return $buttons;
                    }),
            ])
            ->filters([
                // Filter Nama User
                SelectFilter::make('user_id')
                    ->label('Nama')
                    ->relationship('user', 'name'),

                // Filter Tanggal
                Filter::make('tanggal')
                    ->label('Tanggal')
                    ->form([
                        DatePicker::make('tanggal')->label('Pilih Tanggal'),
                    ])
                    ->query(
                        fn($query, $data) =>
                        $query->when($data['tanggal'], fn($q, $value) =>
                        $q->whereDate('tanggal', $value))
                    ),

                // Filter Hari Ini
                Filter::make('hari_ini')
                    ->label('Hari Ini')
                    ->query(fn($query) => $query->whereDate('tanggal', Carbon::today())),

                // Filter Range Tanggal
                Filter::make('tanggal_range')
                    ->label('Range Tanggal')
                    ->form([
                        DatePicker::make('from')->label('Dari'),
                        DatePicker::make('until')->label('Sampai'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['from'], fn($q) => $q->whereDate('tanggal', '>=', $data['from']))
                            ->when($data['until'], fn($q) => $q->whereDate('tanggal', '<=', $data['until']));
                    }),
            ])
            ->defaultSort('tanggal', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAbsensis::route('/'),
        ];
    }
}
