<?php

namespace App\Services;

use App\Enums\ItemType;
use App\Models\GiftBox;
use App\Models\PackagingOption;
use App\Models\Product;

class CartValidationService
{
    public function validateAndPrice(array $cartItems): array
    {
        $validatedItems = [];
        $subtotal = '0.00';

        foreach ($cartItems as $item) {
            $itemType = $item['type'] ?? null;

            $validated = match ($itemType) {
                'product' => $this->validateProductItem($item),
                'gift_box' => $this->validateGiftBoxItem($item),
                'custom_gift_box' => $this->validateCustomGiftBoxItem($item),
                default => null,
            };

            if ($validated === null) {
                continue;
            }

            $validatedItems[] = $validated;
            $subtotal = bcadd($subtotal, $validated['total_price'], 2);
        }

        $packagingCost = $this->calculatePackagingCost($validatedItems);
        $total = bcadd($subtotal, $packagingCost, 2);

        return [
            'items' => $validatedItems,
            'subtotal' => $subtotal,
            'packaging_cost' => $packagingCost,
            'total' => $total,
        ];
    }

    private function validateProductItem(array $item): ?array
    {
        $product = Product::active()
            ->select(['id', 'name', 'price', 'stock_quantity', 'is_active'])
            ->find($item['product_id'] ?? null);

        if ($product === null || ! $product->isAvailable()) {
            return null;
        }

        $quantity = max(1, (int) ($item['quantity'] ?? 1));

        if ($product->stock_quantity !== null && $quantity > $product->stock_quantity) {
            $quantity = $product->stock_quantity;
        }

        $unitPrice = $product->price;
        $totalPrice = bcmul((string) $unitPrice, (string) $quantity, 2);

        return [
            'type' => ItemType::Product->value,
            'product_id' => $product->id,
            'gift_box_id' => null,
            'name_snapshot' => $product->name,
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'total_price' => $totalPrice,
            'customization_data' => null,
        ];
    }

    private function validateGiftBoxItem(array $item): ?array
    {
        $giftBox = GiftBox::active()
            ->select(['id', 'name', 'price', 'is_active'])
            ->find($item['gift_box_id'] ?? null);

        if ($giftBox === null) {
            return null;
        }

        $quantity = max(1, (int) ($item['quantity'] ?? 1));
        $unitPrice = $giftBox->price;
        $totalPrice = bcmul((string) $unitPrice, (string) $quantity, 2);

        return [
            'type' => ItemType::ReadyMadeGiftBox->value,
            'product_id' => null,
            'gift_box_id' => $giftBox->id,
            'name_snapshot' => $giftBox->name,
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'total_price' => $totalPrice,
            'customization_data' => null,
        ];
    }

    private function validateCustomGiftBoxItem(array $item): ?array
    {
        $selectedProducts = $item['products'] ?? [];

        if (empty($selectedProducts)) {
            return null;
        }

        $productIds = array_column($selectedProducts, 'product_id');
        $products = Product::active()
            ->select(['id', 'name', 'price', 'stock_quantity', 'is_active'])
            ->whereIn('id', $productIds)
            ->get()
            ->keyBy('id');

        $validatedProducts = [];
        $productsSubtotal = '0.00';

        foreach ($selectedProducts as $sp) {
            $product = $products->get($sp['product_id'] ?? null);

            if ($product === null || ! $product->isAvailable()) {
                continue;
            }

            $qty = max(1, (int) ($sp['quantity'] ?? 1));
            $lineTotal = bcmul((string) $product->price, (string) $qty, 2);
            $productsSubtotal = bcadd($productsSubtotal, $lineTotal, 2);

            $validatedProducts[] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'quantity' => $qty,
                'unit_price' => (string) $product->price,
                'line_total' => $lineTotal,
            ];
        }

        if (empty($validatedProducts)) {
            return null;
        }

        $packagingOptionId = $item['packaging_option_id'] ?? null;
        $packagingCost = '0.00';
        $packagingName = null;

        if ($packagingOptionId) {
            $packagingOption = PackagingOption::where('is_active', true)
                ->select(['id', 'name', 'price'])
                ->find($packagingOptionId);

            if ($packagingOption) {
                $packagingCost = (string) $packagingOption->price;
                $packagingName = $packagingOption->name;
            }
        }

        $unitPrice = bcadd($productsSubtotal, $packagingCost, 2);
        $quantity = 1;
        $totalPrice = $unitPrice;

        $customizationData = [
            'products' => $validatedProducts,
            'products_subtotal' => $productsSubtotal,
            'packaging_option_id' => $packagingOptionId,
            'packaging_name' => $packagingName,
            'packaging_cost' => $packagingCost,
            'personal_message' => substr((string) ($item['personal_message'] ?? ''), 0, 500),
            'occasion' => $item['occasion'] ?? null,
            'recipient_type' => $item['recipient_type'] ?? null,
        ];

        return [
            'type' => ItemType::CustomGiftBox->value,
            'product_id' => null,
            'gift_box_id' => null,
            'name_snapshot' => 'صندوق هدايا مخصص',
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'total_price' => $totalPrice,
            'customization_data' => $customizationData,
        ];
    }

    private function calculatePackagingCost(array $validatedItems): string
    {
        $cost = '0.00';

        foreach ($validatedItems as $item) {
            if ($item['type'] === ItemType::CustomGiftBox->value) {
                $cost = bcadd($cost, $item['customization_data']['packaging_cost'] ?? '0.00', 2);
            }
        }

        return $cost;
    }
}
