<div x-data="{ show: false }" class="relative">
    <input 
        x-bind:type="show ? 'text' : 'password'" 
        {{ $attributes->merge([
            'class' => 'fi-input block w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500'
        ]) }}
    />

    <button type="button" 
        x-on:click="show = !show" 
        class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500">
        <svg xmlns="http://www.w3.org/2000/svg" 
             fill="none" 
             viewBox="0 0 24 24" 
             stroke-width="1.5" 
             stroke="currentColor" 
             class="w-5 h-5">
            <path x-show="!show" stroke-linecap="round" stroke-linejoin="round" d="M2.25 12c2.25-4.5 6.75-7.5 9.75-7.5s7.5 3 9.75 7.5c-2.25 4.5-6.75 7.5-9.75 7.5S4.5 16.5 2.25 12z" />
            <path x-show="show" stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
    </button>
</div>
