<?php

namespace App\Services;

use App\Models\Stock;
use App\Models\StockTransfer;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class TransferService
{
    /**
     * Request a stock transfer (creates pending transfer).
     * Does not move stock until completed.
     */
    public function requestTransfer(
        int $fromStoreId,
        int $toStoreId,
        int $productId,
        int $quantity,
        ?User $requestedBy = null
    ): StockTransfer {
        if ($quantity <= 0) {
            throw new InvalidArgumentException('Quantity must be positive.');
        }
        if ($fromStoreId === $toStoreId) {
            throw new InvalidArgumentException('Source and destination store must be different.');
        }

        return StockTransfer::create([
            'from_store_id' => $fromStoreId,
            'to_store_id' => $toStoreId,
            'product_id' => $productId,
            'quantity' => $quantity,
            'status' => StockTransfer::STATUS_PENDING,
            'requested_by_user_id' => $requestedBy?->id,
        ]);
    }

    /**
     * Complete a pending transfer: decrease source stock, increase destination stock.
     *
     * @throws InvalidArgumentException when transfer not pending or insufficient stock
     */
    public function completeTransfer(int $transferId): StockTransfer
    {
        return DB::transaction(function () use ($transferId): StockTransfer {
            $transfer = StockTransfer::findOrFail($transferId);

            if (! $transfer->isPending()) {
                throw new InvalidArgumentException('Only pending transfers can be completed.');
            }

            $fromStock = Stock::where('store_id', $transfer->from_store_id)
                ->where('product_id', $transfer->product_id)
                ->lockForUpdate()
                ->first();

            if (! $fromStock || $fromStock->quantity < $transfer->quantity) {
                throw new InvalidArgumentException('Insufficient stock at source store to complete transfer.');
            }

            $fromStock->decrement('quantity', $transfer->quantity);

            $toStock = Stock::firstOrCreate(
                [
                    'store_id' => $transfer->to_store_id,
                    'product_id' => $transfer->product_id,
                ],
                ['quantity' => 0]
            );
            $toStock->increment('quantity', $transfer->quantity);

            $transfer->update([
                'status' => StockTransfer::STATUS_COMPLETED,
                'completed_at' => now(),
            ]);

            return $transfer->fresh();
        });
    }

    /**
     * Cancel a pending transfer.
     */
    public function cancelTransfer(int $transferId): StockTransfer
    {
        $transfer = StockTransfer::findOrFail($transferId);
        if (! $transfer->isPending()) {
            throw new InvalidArgumentException('Only pending transfers can be cancelled.');
        }
        $transfer->update(['status' => StockTransfer::STATUS_CANCELLED]);

        return $transfer->fresh();
    }
}
