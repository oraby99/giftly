<?php

namespace App\Models;

use App\Enums\ReviewStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'product_id', 'gift_box_id', 'order_id', 'order_item_id',
    'review_token', 'rating', 'comment', 'customer_name', 'status',
])]
class Review extends Model
{
    protected function casts(): array
    {
        return [
            'status' => ReviewStatus::class,
            'rating' => 'integer',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function giftBox(): BelongsTo
    {
        return $this->belongsTo(GiftBox::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class, 'order_item_id');
    }

    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('status', ReviewStatus::Approved->value);
    }
}
