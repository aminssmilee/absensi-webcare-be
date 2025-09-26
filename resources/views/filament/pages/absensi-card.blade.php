<x-filament-widgets::widget>
    <x-filament::section>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- ✅ Sudah Absen --}}
            <div class="border rounded-lg shadow p-4">
                <h2 class="text-lg font-bold mb-2 text-green-600">
                    ✅ Sudah Absen ({{ $this->getData()['sudahAbsen']->count() }})
                </h2>
                <table class="w-full text-sm border">
                    <thead class="bg-green-600 text-black">
                        <tr>
                            <th class="px-3 py-2 text-left">Nama</th>
                            <th class="px-3 py-2 text-left">Jam Masuk</th>
                            <th class="px-3 py-2 text-left">Jam Keluar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($this->getData()['sudahAbsen'] as $user)
                            @php
                                $absensi = $user->absensis->where('tanggal', now()->toDateString())->first();
                            @endphp
                            <tr class="border-b">
                                <td class="px-3 py-2">{{ $user->name }}</td>
                                <td class="px-3 py-2">{{ $absensi?->jam_masuk ?? '-' }}</td>
                                <td class="px-3 py-2">{{ $absensi?->jam_keluar ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-3 py-2 text-center text-gray-500">
                                    Belum ada yang absen
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- ❌ Belum Absen --}}
            <div class="border rounded-lg shadow p-4">
                <h2 class="text-lg font-bold mb-2 text-red-600">
                    ❌ Belum Absen ({{ $this->getData()['belumAbsen']->count() }})
                </h2>
                <table class="w-full text-sm border">
                    <thead class="bg-red-600 text-black">
                        <tr>
                            <th class="px-3 py-2 text-left">Nama</th>
                            {{-- <th class="px-3 py-2 text-left">Jam Masuk</th> --}}
                            {{-- <th class="px-3 py-2 text-left">Jam Keluar</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($this->getData()['belumAbsen'] as $user)
                            <tr class="border-b">
                                <td class="px-3 py-2">{{ $user->name }}</td>
                                {{-- <td class="px-3 py-2">-</td> --}}
                                {{-- <td class="px-3 py-2">-</td> --}}
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-3 py-2 text-center text-gray-500">
                                    Semua sudah absen 🎉
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </x-filament::section>
</x-filament-widgets::widget>
