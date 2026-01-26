<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'sku', 'price'];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
        ];
    }

    public function stockEntries(): HasMany
    {
        return $this->hasMany(Stock::class, 'product_id');
    }

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class, 'product_id');
    }

    public function stockTransfers(): HasMany
    {
        return $this->hasMany(StockTransfer::class, 'product_id');
    }
}
