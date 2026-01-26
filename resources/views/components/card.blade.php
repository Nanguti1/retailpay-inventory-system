@props(['title' => null, 'class' => ''])
<div {{ $attributes->merge(['class' => 'rounded-xl border border-zinc-200 bg-white shadow-sm ' . $class]) }}>
    @if ($title)
        <div class="border-b border-zinc-100 px-5 py-4">
            <h3 class="font-semibold text-zinc-900">{{ $title }}</h3>
        </div>
    @endif
    <div class="p-5">
        {{ $slot }}
    </div>
</div>
