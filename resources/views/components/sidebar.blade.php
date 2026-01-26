@php
    $nav = [
        ['label' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
        ['label' => 'Products', 'route' => 'products.index', 'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'],
        ['label' => 'Sales', 'route' => 'sales.index', 'icon' => 'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z'],
        ['label' => 'Transfers', 'route' => 'transfers.index', 'icon' => 'M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4'],
    ];
@endphp
<div class="fixed inset-y-0 left-0 z-40 w-64 bg-zinc-900 lg:block"
     :class="{ 'block': sidebarOpen, 'hidden': !sidebarOpen }"
     x-show="true"
     x-transition
     @click.away="sidebarOpen = false">
    <div class="flex h-14 items-center border-b border-zinc-800 px-6">
        <a href="{{ route('dashboard') }}" class="text-lg font-semibold text-white">{{ config('app.name') }}</a>
    </div>
    <nav class="mt-4 space-y-0.5 px-3">
        @foreach ($nav as $item)
            <a href="{{ route($item['route']) }}"
               class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition-colors
                      {{ request()->routeIs($item['route'].'*') ? 'bg-zinc-800 text-white' : 'text-zinc-400 hover:bg-zinc-800 hover:text-white' }}">
                <svg class="h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}" />
                </svg>
                {{ $item['label'] }}
            </a>
        @endforeach
    </nav>
</div>
<div x-show="sidebarOpen" x-transition class="fixed inset-0 z-30 bg-black/50 lg:hidden" @click="sidebarOpen = false"></div>
