<div class="flex gap-2">
    @if ($getRecord()->lokasi_masuk)
        <x-filament::button
            tag="a"
            href="https://www.google.com/maps?q={{ urlencode($getRecord()->lokasi_masuk) }}"
            target="_blank"
            color="primary"
            size="sm"
        >
            Lokasi Masuk
        </x-filament::button>
    @endif

    @if ($getRecord()->lokasi_keluar)
        <x-filament::button
            tag="a"
            href="https://www.google.com/maps?q={{ urlencode($getRecord()->lokasi_keluar) }}"
            target="_blank"
            color="success"
            size="sm"
        >
            Lokasi Keluar
        </x-filament::button>
    @endif
</div>
