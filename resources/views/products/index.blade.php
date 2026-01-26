@extends('layouts.app')
@section('content')
<div class="mx-auto max-w-7xl">
    <h1 class="text-2xl font-bold text-zinc-900">Products</h1>
    <p class="mt-1 text-zinc-600">Stock levels per store (your allowed stores).</p>
    <x-card class="mt-6">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-zinc-200 text-sm">
                <thead>
                    <tr>
                        <th class="pb-3 text-left font-medium text-zinc-600">Product / SKU</th>
                        <th class="pb-3 text-right font-medium text-zinc-600">Price</th>
                        @foreach ($stores as $s)
                            <th class="pb-3 text-right font-medium text-zinc-600">{{ $s->name }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @foreach ($products as $p)
                        <tr>
                            <td class="py-3">
                                <span class="font-medium text-zinc-900">{{ $p->name }}</span><br>
                                <span class="text-zinc-500">{{ $p->sku }}</span>
                            </td>
                            <td class="text-right">Ksh. {{ number_format($p->price, 2) }}</td>
                            @foreach ($stores as $s)
                                @php $entry = $p->stockEntries->firstWhere('store_id', $s->id); @endphp
                                <td class="text-right">{{ $entry ? $entry->quantity : 0 }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-card>
</div>
@endsection
