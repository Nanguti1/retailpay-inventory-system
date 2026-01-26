@extends('layouts.app')
@section('content')
<div class="mx-auto max-w-7xl">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-zinc-900">Stock transfers</h1>
            <p class="mt-1 text-zinc-600">Request or complete inter-store transfers.</p>
        </div>
        <a href="{{ route('transfers.create') }}" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">New transfer</a>
    </div>
    <x-card class="mt-6">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-zinc-200 text-sm">
                <thead>
                    <tr>
                        <th class="pb-3 text-left font-medium text-zinc-600">From → To</th>
                        <th class="pb-3 text-left font-medium text-zinc-600">Product</th>
                        <th class="pb-3 text-right font-medium text-zinc-600">Qty</th>
                        <th class="pb-3 text-left font-medium text-zinc-600">Status</th>
                        <th class="pb-3 text-left font-medium text-zinc-600">Requested</th>
                        <th class="pb-3 text-right font-medium text-zinc-600">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @forelse ($transfers as $t)
                        <tr>
                            <td class="py-3">{{ $t->fromStore->name }} → {{ $t->toStore->name }}</td>
                            <td>{{ $t->product->name }}</td>
                            <td class="text-right">{{ $t->quantity }}</td>
                            <td>
                                <span class="inline-flex rounded-full px-2 py-0.5 text-xs font-medium
                                    @if($t->status === 'pending') bg-amber-100 text-amber-800
                                    @elseif($t->status === 'completed') bg-emerald-100 text-emerald-800
                                    @else bg-zinc-100 text-zinc-800 @endif">
                                    {{ ucfirst($t->status) }}
                                </span>
                            </td>
                            <td class="text-zinc-500">{{ $t->created_at->format('M j, Y') }}</td>
                            <td class="text-right">
                                @if ($t->isPending())
                                    <form action="{{ route('transfers.complete', $t) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-indigo-600 hover:text-indigo-800">Complete</button>
                                    </form>
                                    <span class="mx-1 text-zinc-300">|</span>
                                    <form action="{{ route('transfers.cancel', $t) }}" method="POST" class="inline" onsubmit="return confirm('Cancel this transfer?');">
                                        @csrf
                                        <button type="submit" class="text-red-600 hover:text-red-800">Cancel</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="py-8 text-center text-zinc-500">No transfers yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $transfers->links() }}</div>
    </x-card>
</div>
@endsection
