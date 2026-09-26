<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Enums\OrderType;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

#[Fillable([
    'order_number', 'customer_name', 'customer_phone', 'customer_address',
    'status', 'subtotal', 'packaging_cost', 'delivery_cost', 'total',
    'customer_notes', 'order_type', 'whatsapp_opened_at',
])]
class Order extends Model
{
    protected function casts(): array
    {
        return [
            'status' => OrderStatus::class,
            'order_type' => OrderType::class,
            'subtotal' => 'decimal:2',
            'packaging_cost' => 'decimal:2',
            'delivery_cost' => 'decimal:2',
            'total' => 'decimal:2',
            'whatsapp_opened_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Order $order) {
            if (empty($order->order_number)) {
                do {
                    $number = 'GFT-'.strtoupper(Str::random(8));
                } while (static::where('order_number', $number)->exists());
                $order->order_number = $number;
            }

            if ($order->subtotal === null) {
                $order->subtotal = 0;
            }
            if ($order->packaging_cost === null) {
                $order->packaging_cost = 0;
            }
            if ($order->delivery_cost === null) {
                $order->delivery_cost = 0;
            }
            if ($order->total === null) {
                $order->total = $order->subtotal + $order->packaging_cost + $order->delivery_cost;
            }
            if ($order->order_type === null) {
                $order->order_type = OrderType::ReadyMade;
            }
            if ($order->status === null) {
                $order->status = OrderStatus::Pending;
            }
        });
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', OrderStatus::Pending->value);
    }

    public function scopeCompleted(Builder $query): Builder
    {
        return $query->where('status', OrderStatus::Completed->value);
    }
}
