@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-7xl">
    <h1 class="text-2xl font-bold text-zinc-900">Dashboard</h1>
    <p class="mt-1 text-zinc-600">Overview of stock, sales, and pending transfers.</p>

    <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <x-card class="sm:col-span-2 lg:col-span-1">
            <p class="text-sm font-medium text-zinc-500">Total stock (allowed stores)</p>
            <p class="mt-1 text-3xl font-bold text-zinc-900">{{ number_format($totalStock) }}</p>
            <p class="mt-1 text-xs text-zinc-500">units</p>
        </x-card>
        <x-card>
            <p class="text-sm font-medium text-zinc-500">Stores</p>
            <ul class="mt-2 space-y-1">
                @foreach ($stockPerStore as $s)
                    <li class="flex justify-between text-sm">
                        <span class="text-zinc-700">{{ $s['name'] }}</span>
                        <span class="font-medium text-zinc-900">{{ number_format($s['total']) }}</span>
                    </li>
                @endforeach
            </ul>
        </x-card>
    </div>

    <div class="mt-8 grid gap-6 lg:grid-cols-2">
        <x-card title="Recent sales">
            @if ($recentSales->isEmpty())
                <p class="text-sm text-zinc-500">No sales yet.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-zinc-200 text-sm">
                        <thead>
                            <tr>
                                <th class="pb-2 text-left font-medium text-zinc-600">Store / Product</th>
                                <th class="pb-2 text-right font-medium text-zinc-600">Qty</th>
                                <th class="pb-2 text-right font-medium text-zinc-600">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100">
                            @foreach ($recentSales as $sale)
                                <tr>
                                    <td class="py-2">
                                        <span class="font-medium text-zinc-900">{{ $sale->store->name }}</span><br>
                                        <span class="text-zinc-500">{{ $sale->product->name }}</span>
                                    </td>
                                    <td class="text-right">{{ $sale->quantity }}</td>
                                    <td class="text-right text-zinc-500">{{ $sale->sold_at->format('M j, Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </x-card>
        <x-card title="Pending transfers">
            @if ($pendingTransfers->isEmpty())
                <p class="text-sm text-zinc-500">No pending transfers.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-zinc-200 text-sm">
                        <thead>
                            <tr>
                                <th class="pb-2 text-left font-medium text-zinc-600">From → To</th>
                                <th class="pb-2 text-left font-medium text-zinc-600">Product</th>
                                <th class="pb-2 text-right font-medium text-zinc-600">Qty</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100">
                            @foreach ($pendingTransfers as $t)
                                <tr>
                                    <td class="py-2">
                                        {{ $t->fromStore->name }} → {{ $t->toStore->name }}
                                    </td>
                                    <td>{{ $t->product->name }}</td>
                                    <td class="text-right">{{ $t->quantity }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    <a href="{{ route('transfers.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">View all transfers →</a>
                </div>
            @endif
        </x-card>
    </div>
</div>
@endsection
