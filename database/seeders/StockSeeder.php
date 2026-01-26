<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Stock;
use App\Models\Store;
use Illuminate\Database\Seeder;

class StockSeeder extends Seeder
{
    public function run(): void
    {
        $stores = Store::all();
        $products = Product::all();

        foreach ($stores as $store) {
            foreach ($products as $product) {
                Stock::create([
                    'store_id' => $store->id,
                    'product_id' => $product->id,
                    'quantity' => 100,
                ]);
            }
        }
    }
}
