<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\Widget;

class AbsensiCard extends Widget
{
    protected static string $view = 'filament.pages.absensi-card';
    protected int | string | array $columnSpan = 'full';

    public function getData(): array
    {
        $hariIni = now()->toDateString();

        return [
            // ✅ Sudah absen, tapi bukan admin
            'sudahAbsen' => User::where('role', '!=', 'admin')
                ->whereHas('absensis', fn($q) => $q->whereDate('tanggal', $hariIni))
                ->get(),

            // ❌ Belum absen, tapi bukan admin
            'belumAbsen' => User::where('role', '!=', 'admin')
                ->whereDoesntHave('absensis', fn($q) => $q->whereDate('tanggal', $hariIni))
                ->get(),
        ];
    }
}
