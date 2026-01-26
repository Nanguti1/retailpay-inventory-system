<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Store extends Model
{
    protected $fillable = ['name', 'branch_id'];

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function stockEntries(): HasMany
    {
        return $this->hasMany(Stock::class, 'store_id');
    }

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class, 'store_id');
    }

    public function transfersFrom(): HasMany
    {
        return $this->hasMany(StockTransfer::class, 'from_store_id');
    }

    public function transfersTo(): HasMany
    {
        return $this->hasMany(StockTransfer::class, 'to_store_id');
    }
}
