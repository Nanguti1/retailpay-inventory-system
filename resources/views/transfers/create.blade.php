@extends('layouts.app')
@section('content')
<div class="mx-auto max-w-2xl">
    <h1 class="text-2xl font-bold text-zinc-900">Request stock transfer</h1>
    <p class="mt-1 text-zinc-600">Request stock to be moved from one store to another. {{ auth()->user()->canFacilitateTransfers() ? 'Branch managers and admins can also complete or cancel transfers from the list.' : 'A branch manager or administrator will complete the transfer.' }}</p>
    <x-card class="mt-6">
        <form method="POST" action="{{ route('transfers.store') }}" class="space-y-4">
            @csrf
            <div>
                <label for="from_store_id" class="block text-sm font-medium text-zinc-700">From store</label>
                <select id="from_store_id" name="from_store_id" required class="mt-1 block w-full rounded-lg border border-zinc-300 px-3 py-2 @error('from_store_id') border-red-500 @enderror">
                    <option value="">Select source store</option>
                    @foreach ($allowedStores as $s)
                        <option value="{{ $s->id }}" {{ old('from_store_id') == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                    @endforeach
                </select>
                @error('from_store_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="to_store_id" class="block text-sm font-medium text-zinc-700">To store</label>
                <select id="to_store_id" name="to_store_id" required class="mt-1 block w-full rounded-lg border border-zinc-300 px-3 py-2 @error('to_store_id') border-red-500 @enderror">
                    <option value="">Select destination store</option>
                    @foreach ($allowedStores as $s)
                        <option value="{{ $s->id }}" {{ old('to_store_id') == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                    @endforeach
                </select>
                @error('to_store_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="product_id" class="block text-sm font-medium text-zinc-700">Product</label>
                <select id="product_id" name="product_id" required class="mt-1 block w-full rounded-lg border border-zinc-300 px-3 py-2 @error('product_id') border-red-500 @enderror">
                    <option value="">Select product</option>
                    @foreach ($products as $p)
                        <option value="{{ $p->id }}" {{ old('product_id') == $p->id ? 'selected' : '' }}>{{ $p->name }} ({{ $p->sku }})</option>
                    @endforeach
                </select>
                @error('product_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="quantity" class="block text-sm font-medium text-zinc-700">Quantity</label>
                <input id="quantity" type="number" name="quantity" value="{{ old('quantity', 1) }}" min="1" required
                    class="mt-1 block w-full rounded-lg border border-zinc-300 px-3 py-2 @error('quantity') border-red-500 @enderror" />
                @error('quantity')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div class="flex gap-3">
                <x-button>Request transfer</x-button>
                <a href="{{ route('transfers.index') }}" class="inline-flex items-center rounded-lg bg-zinc-100 px-4 py-2 text-sm font-medium text-zinc-800 hover:bg-zinc-200">Cancel</a>
            </div>
        </form>
    </x-card>
</div>
@endsection
