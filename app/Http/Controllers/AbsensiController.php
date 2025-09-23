<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    // 🔹 Ambil waktu server (Asia/Jakarta)
    public function time()
    {
        return response()->json([
            'datetime' => now()->format('Y-m-d H:i:s'),
            'date'     => now()->format('Y-m-d'),
            'time'     => now()->format('H:i:s'),
        ]);
    }

    // 🔹 Menyimpan absensi masuk / keluar / izin
    public function store(Request $request)
    {
        $request->validate([
            'type'   => 'required|in:Masuk,Keluar,Izin',
            'lokasi' => 'nullable|string',
            'deskripsi' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();
        $today = now()->format('Y-m-d');

        $absensi = Absensi::firstOrCreate(
            ['user_id' => $user->id, 'tanggal' => $today],
            ['jam_masuk' => null, 'jam_keluar' => null, 'lokasi_masuk' => null, 'lokasi_keluar' => null, 'deskripsi' => null]
        );

        // 🔹 Jika izin
        if ($request->type === 'Izin') {
            if ($absensi->deskripsi) {
                return response()->json(['message' => 'Anda sudah mengajukan izin hari ini'], 400);
            }

            $absensi->update([
                'deskripsi' => $request->deskripsi ?? 'Izin tanpa keterangan',
            ]);

            return response()->json(['message' => 'Izin berhasil dicatat', 'data' => $absensi]);
        }

        // 🔹 Jika Masuk
        if ($request->type === 'Masuk' && !$absensi->jam_masuk) {
            $absensi->update([
                'jam_masuk' => now()->format('H:i:s'),
                'lokasi_masuk' => $request->lokasi
            ]);
        }
        // 🔹 Jika Keluar
        elseif ($request->type === 'Keluar' && !$absensi->jam_keluar) {
            $absensi->update([
                'jam_keluar' => now()->format('H:i:s'),
                'lokasi_keluar' => $request->lokasi
            ]);
        } else {
            return response()->json(['message' => "Sudah absen {$request->type} hari ini"], 400);
        }

        return response()->json($absensi);
    }

    // 🔹 Ambil history absensi user
    public function history()
    {
        $user = Auth::user();
        $history = Absensi::where('user_id', $user->id)
            ->orderBy('tanggal', 'desc')
            ->get();

        return response()->json(
            $history->map(function ($item) {
                return [
                    'date'          => $item->tanggal,
                    'jam_masuk'     => $item->jam_masuk,
                    'jam_keluar'    => $item->jam_keluar,
                    'lokasi_masuk'  => $item->lokasi_masuk,
                    'lokasi_keluar' => $item->lokasi_keluar,
                    'type'          => $item->type,
                    'deskripsi'     => $item->deskripsi,
                ];
            })
        );
    }
}
