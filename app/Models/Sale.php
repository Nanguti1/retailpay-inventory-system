<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sale extends Model
{
    protected $fillable = ['store_id', 'product_id', 'quantity', 'unit_price', 'sold_at', 'user_id'];

    protected function casts(): array
    {
        return [
            'unit_price' => 'decimal:2',
            'sold_at' => 'datetime',
        ];
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getTotalAttribute(): string
    {
        return number_format((float) $this->unit_price * $this->quantity, 2);
    }
}
