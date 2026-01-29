<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockTransfer;
use App\Models\Store;
use App\Services\TransferService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use InvalidArgumentException;

class StockTransferController extends Controller
{
    public function __construct(
        private TransferService $transferService
    ) {}

    public function index(): View
    {
        $storeIds = auth()->user()->allowedStoreIds();

        $transfers = StockTransfer::with(['fromStore', 'toStore', 'product', 'requestedBy'])
            ->where(function ($q) use ($storeIds): void {
                $q->whereIn('from_store_id', $storeIds)
                    ->orWhereIn('to_store_id', $storeIds);
            })
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('transfers.index', [
            'transfers' => $transfers,
            'title' => 'Transfers',
        ]);
    }

    public function create(): View
    {
        $storeIds = auth()->user()->allowedStoreIds();
        $allowedStores = Store::whereIn('id', $storeIds)->orderBy('name')->get();
        $products = Product::orderBy('name')->get();

        return view('transfers.create', [
            'allowedStores' => $allowedStores,
            'products' => $products,
            'title' => 'Request transfer',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $storeIds = auth()->user()->allowedStoreIds();

        $validated = $request->validate([
            'from_store_id' => ['required', 'integer', 'in:'.implode(',', $storeIds)],
            'to_store_id' => ['required', 'integer', 'exists:stores,id', 'different:from_store_id'],
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        try {
            $this->transferService->requestTransfer(
                (int) $validated['from_store_id'],
                (int) $validated['to_store_id'],
                (int) $validated['product_id'],
                (int) $validated['quantity'],
                auth()->user()
            );
        } catch (InvalidArgumentException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }

        return redirect()->route('transfers.index')->with('success', 'Transfer requested successfully.');
    }

    public function complete(int $id): RedirectResponse
    {
        if (! auth()->user()->canFacilitateTransfers()) {
            abort(403, 'Only branch managers or administrators can complete transfers.');
        }

        $storeIds = auth()->user()->allowedStoreIds();
        $transfer = StockTransfer::findOrFail($id);

        if (! in_array($transfer->from_store_id, $storeIds, true) && ! in_array($transfer->to_store_id, $storeIds, true)) {
            abort(403);
        }

        try {
            $this->transferService->completeTransfer($id);
        } catch (InvalidArgumentException $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'Transfer completed.');
    }

    public function cancel(int $id): RedirectResponse
    {
        if (! auth()->user()->canFacilitateTransfers()) {
            abort(403, 'Only branch managers or administrators can cancel transfers.');
        }

        $storeIds = auth()->user()->allowedStoreIds();
        $transfer = StockTransfer::findOrFail($id);

        if (! in_array($transfer->from_store_id, $storeIds, true) && ! in_array($transfer->to_store_id, $storeIds, true)) {
            abort(403);
        }

        try {
            $this->transferService->cancelTransfer($id);
        } catch (InvalidArgumentException $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'Transfer cancelled.');
    }
}
