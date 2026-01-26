@extends('layouts.app')
@section('content')
<div class="mx-auto max-w-7xl">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-zinc-900">Sales</h1>
            <p class="mt-1 text-zinc-600">Sales history for your stores.</p>
        </div>
        <a href="{{ route('sales.create') }}" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">Record sale</a>
    </div>
    <x-card class="mt-6">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-zinc-200 text-sm">
                <thead>
                    <tr>
                        <th class="pb-3 text-left font-medium text-zinc-600">Date</th>
                        <th class="pb-3 text-left font-medium text-zinc-600">Store</th>
                        <th class="pb-3 text-left font-medium text-zinc-600">Product</th>
                        <th class="pb-3 text-right font-medium text-zinc-600">Qty</th>
                        <th class="pb-3 text-right font-medium text-zinc-600">Unit price</th>
                        <th class="pb-3 text-right font-medium text-zinc-600">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @forelse ($sales as $sale)
                        <tr>
                            <td class="py-3 text-zinc-600">{{ $sale->sold_at->format('M j, Y H:i') }}</td>
                            <td>{{ $sale->store->name }}</td>
                            <td>{{ $sale->product->name }}</td>
                            <td class="text-right">{{ $sale->quantity }}</td>
                            <td class="text-right">Ksh. {{ number_format($sale->unit_price, 2) }}</td>
                            <td class="text-right font-medium">Ksh. {{ $sale->total }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="py-8 text-center text-zinc-500">No sales recorded yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $sales->links() }}</div>
    </x-card>
</div>
@endsection
