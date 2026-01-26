@props(['id' => 'modal', 'title' => 'Confirm'])
<div x-data="{ open: false }"
     x-on:open-modal.window="if ($event.detail === '{{ $id }}') open = true"
     x-on:close-modal.window="if ($event.detail === '{{ $id }}') open = false"
     x-show="open"
     x-cloak
     class="fixed inset-0 z-50 overflow-y-auto"
     style="display: none;">
    <div class="flex min-h-full items-center justify-center p-4">
        <div x-show="open" x-transition class="fixed inset-0 bg-black/50" @click="open = false"></div>
        <div x-show="open" x-transition class="relative z-10 w-full max-w-md rounded-xl bg-white p-6 shadow-xl">
            <h3 class="text-lg font-semibold text-zinc-900">{{ $title }}</h3>
            <div class="mt-4">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
