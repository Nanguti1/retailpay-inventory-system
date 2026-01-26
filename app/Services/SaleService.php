<?php

namespace App\Services;

use App\Models\Sale;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class SaleService
{
    /**
     * Record a sale: reduce store stock and create sale transaction.
     *
     * @throws InvalidArgumentException when insufficient stock
     */
    public function recordSale(int $storeId, int $productId, int $quantity, ?User $user = null): Sale
    {
        if ($quantity <= 0) {
            throw new InvalidArgumentException('Quantity must be positive.');
        }

        return DB::transaction(function () use ($storeId, $productId, $quantity, $user): Sale {
            $stock = Stock::where('store_id', $storeId)
                ->where('product_id', $productId)
                ->lockForUpdate()
                ->first();

            if (! $stock || $stock->quantity < $quantity) {
                throw new InvalidArgumentException('Insufficient stock for this product at the selected store.');
            }

            $product = $stock->product;
            $stock->decrement('quantity', $quantity);

            return Sale::create([
                'store_id' => $storeId,
                'product_id' => $productId,
                'quantity' => $quantity,
                'unit_price' => $product->price,
                'sold_at' => now(),
                'user_id' => $user?->id,
            ]);
        });
    }
}
