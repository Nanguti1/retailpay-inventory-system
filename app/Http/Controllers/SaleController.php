<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\Store;
use App\Services\SaleService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use InvalidArgumentException;

class SaleController extends Controller
{
    public function __construct(
        private SaleService $saleService
    ) {}

    public function index(): View
    {
        $storeIds = auth()->user()->allowedStoreIds();

        $sales = Sale::with(['store', 'product', 'user'])
            ->whereIn('store_id', $storeIds)
            ->orderByDesc('sold_at')
            ->paginate(15);

        return view('sales.index', ['sales' => $sales, 'title' => 'Sales']);
    }

    public function create(): View
    {
        $storeIds = auth()->user()->allowedStoreIds();
        $stores = Store::whereIn('id', $storeIds)->orderBy('name')->get();
        $products = Product::orderBy('name')->get();

        return view('sales.create', [
            'stores' => $stores,
            'products' => $products,
            'title' => 'New sale',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $storeIds = auth()->user()->allowedStoreIds();

        $validated = $request->validate([
            'store_id' => ['required', 'integer', 'in:'.implode(',', $storeIds)],
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        try {
            $this->saleService->recordSale(
                (int) $validated['store_id'],
                (int) $validated['product_id'],
                (int) $validated['quantity'],
                auth()->user()
            );
        } catch (InvalidArgumentException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }

        return redirect()->route('sales.index')->with('success', 'Sale simulated successfully.');
    }
}
