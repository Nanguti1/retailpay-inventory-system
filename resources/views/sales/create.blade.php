@extends('layouts.app')
@section('content')
<div class="mx-auto max-w-2xl">
    <h1 class="text-2xl font-bold text-zinc-900">Record sale</h1>
    <p class="mt-1 text-zinc-600">Reduce stock at a store and record the transaction.</p>
    <x-card class="mt-6">
        <form method="POST" action="{{ route('sales.store') }}" class="space-y-4">
            @csrf
            <div>
                <label for="store_id" class="block text-sm font-medium text-zinc-700">Store</label>
                <select id="store_id" name="store_id" required class="mt-1 block w-full rounded-lg border border-zinc-300 px-3 py-2 @error('store_id') border-red-500 @enderror">
                    <option value="">Select store</option>
                    @foreach ($stores as $s)
                        <option value="{{ $s->id }}" {{ old('store_id') == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                    @endforeach
                </select>
                @error('store_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
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
                <x-button>Record sale</x-button>
                <a href="{{ route('sales.index') }}" class="inline-flex items-center rounded-lg bg-zinc-100 px-4 py-2 text-sm font-medium text-zinc-800 hover:bg-zinc-200">Cancel</a>
            </div>
        </form>
    </x-card>
</div>
@endsection
