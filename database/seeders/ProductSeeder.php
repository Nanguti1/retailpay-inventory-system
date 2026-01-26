<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $skus = [
            ['name' => 'Widget Pro', 'sku' => 'SKU-001', 'price' => 29.99],
            ['name' => 'Gadget Basic', 'sku' => 'SKU-002', 'price' => 14.50],
            ['name' => 'Tool Set Standard', 'sku' => 'SKU-003', 'price' => 49.99],
            ['name' => 'Cable Pack', 'sku' => 'SKU-004', 'price' => 9.99],
            ['name' => 'Storage Box Medium', 'sku' => 'SKU-005', 'price' => 19.99],
            ['name' => 'Display Unit', 'sku' => 'SKU-006', 'price' => 89.00],
            ['name' => 'Adapter Universal', 'sku' => 'SKU-007', 'price' => 12.00],
            ['name' => 'Battery Pack', 'sku' => 'SKU-008', 'price' => 34.99],
            ['name' => 'Stand Premium', 'sku' => 'SKU-009', 'price' => 45.00],
            ['name' => 'Case Protective', 'sku' => 'SKU-010', 'price' => 24.99],
        ];

        foreach ($skus as $item) {
            Product::create($item);
        }
    }
}
