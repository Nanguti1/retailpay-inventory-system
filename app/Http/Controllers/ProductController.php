<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Store;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        $storeIds = auth()->user()->allowedStoreIds();

        $products = Product::orderBy('name')->get();
        $stores = Store::whereIn('id', $storeIds)->orderBy('name')->get();

        foreach ($products as $product) {
            $product->load(['stockEntries' => fn ($q) => $q->whereIn('store_id', $storeIds)->with('store')]);
        }

        return view('products.index', compact('products', 'stores'));
    }
}
