<?php

namespace App\Models;

use App\Enums\ItemType;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'order_id', 'item_type', 'product_id', 'gift_box_id',
    'name_snapshot', 'quantity', 'unit_price', 'total_price', 'customization_data',
])]
class OrderItem extends Model
{
    protected function casts(): array
    {
        return [
            'item_type' => ItemType::class,
            'quantity' => 'integer',
            'unit_price' => 'decimal:2',
            'total_price' => 'decimal:2',
            'customization_data' => 'array',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function giftBox(): BelongsTo
    {
        return $this->belongsTo(GiftBox::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'order_item_id');
    }
}
