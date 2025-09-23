<form method="POST" action="{{ url('/admin/logout') }}">
    @csrf
    <button 
        type="submit"
        class="flex items-center gap-2 w-full px-3 py-2 text-red-600 hover:bg-red-100 rounded-md transition"
    >
        <x-filament::icon icon="heroicon-o-arrow-right-on-rectangle" class="w-5 h-5"/>
        <span>Logout</span>
    </button>
</form>
