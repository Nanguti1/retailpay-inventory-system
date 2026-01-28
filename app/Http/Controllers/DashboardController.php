<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Stock;
use App\Models\StockTransfer;
use App\Models\Store;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();
        $storeIds = $user->allowedStoreIds();

        $totalStock = Stock::whereIn('store_id', $storeIds)->sum('quantity');

        $stockPerStore = Store::whereIn('id', $storeIds)->get()->map(function (Store $s) {
            return [
                'name' => $s->name,
                'total' => (int) $s->stockEntries()->sum('quantity'),
            ];
        });

        $recentSales = Sale::with(['store', 'product'])
            ->whereIn('store_id', $storeIds)
            ->orderByDesc('sold_at')
            ->limit(10)
            ->get();

        $pendingTransfers = StockTransfer::with(['fromStore', 'toStore', 'product'])
            ->where('status', StockTransfer::STATUS_PENDING)
            ->where(function ($q) use ($storeIds) {
                $q->whereIn('from_store_id', $storeIds)
                    ->orWhereIn('to_store_id', $storeIds);
            })
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        return view('dashboard', [
            'title' => 'Dashboard',
            'totalStock' => $totalStock,
            'stockPerStore' => $stockPerStore,
            'recentSales' => $recentSales,
            'pendingTransfers' => $pendingTransfers,
        ]);
    }
}
