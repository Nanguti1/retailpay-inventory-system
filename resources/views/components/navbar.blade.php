<nav class="sticky top-0 z-30 border-b border-zinc-200 bg-white/95 backdrop-blur">
    <div class="mx-auto flex h-14 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
        <button type="button" @click="sidebarOpen = !sidebarOpen" class="lg:hidden rounded-md p-2 text-zinc-600 hover:bg-zinc-100">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
        <div class="flex-1 lg:flex-none"></div>
        <div class="flex items-center gap-3">
            <span class="text-sm text-zinc-600">{{ auth()->user()->name }}</span>
            <span class="rounded-full bg-zinc-200 px-2 py-0.5 text-xs font-medium text-zinc-700">
                {{ ucfirst(str_replace('_', ' ', auth()->user()->role)) }}
            </span>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="text-sm text-zinc-600 hover:text-zinc-900">Logout</button>
            </form>
        </div>
    </div>
</nav>
