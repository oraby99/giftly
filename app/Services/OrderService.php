<?php

namespace App\Services;

use App\Enums\ItemType;
use App\Enums\OrderStatus;
use App\Enums\OrderType;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderService
{
    public function createFromCart(array $validatedCart, array $customerData = []): Order
    {
        return DB::transaction(function () use ($validatedCart, $customerData) {
            $items = $validatedCart['items'];
            $orderType = $this->determineOrderType($items);

            $order = Order::create([
                'order_number' => $this->generateOrderNumber(),
                'customer_name' => $customerData['customer_name'] ?? null,
                'customer_phone' => $customerData['customer_phone'] ?? null,
                'customer_address' => $customerData['customer_address'] ?? null,
                'customer_notes' => $customerData['customer_notes'] ?? null,
                'status' => OrderStatus::Pending->value,
                'subtotal' => $validatedCart['subtotal'],
                'packaging_cost' => $validatedCart['packaging_cost'],
                'delivery_cost' => null,
                'total' => $validatedCart['total'],
                'order_type' => $orderType->value,
            ]);

            foreach ($items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'item_type' => $item['type'],
                    'product_id' => $item['product_id'],
                    'gift_box_id' => $item['gift_box_id'],
                    'name_snapshot' => $item['name_snapshot'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'total_price' => $item['total_price'],
                    'customization_data' => $item['customization_data'],
                ]);
            }

            return $order->load('items');
        });
    }

    private function generateOrderNumber(): string
    {
        do {
            $number = 'GFT-'.strtoupper(Str::random(8));
        } while (Order::where('order_number', $number)->exists());

        return $number;
    }

    private function determineOrderType(array $items): OrderType
    {
        $hasCustom = false;
        $hasReadyMade = false;

        foreach ($items as $item) {
            if ($item['type'] === ItemType::CustomGiftBox->value) {
                $hasCustom = true;
            } else {
                $hasReadyMade = true;
            }
        }

        if ($hasCustom && $hasReadyMade) {
            return OrderType::Mixed;
        }

        if ($hasCustom) {
            return OrderType::Custom;
        }

        return OrderType::ReadyMade;
    }
}
