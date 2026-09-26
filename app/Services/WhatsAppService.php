<?php

namespace App\Services;

use App\Enums\ItemType;
use App\Models\Order;

class WhatsAppService
{
    public function __construct(
        private readonly SettingsService $settings,
    ) {}

    public function generateUrl(Order $order): string
    {
        $message = $this->buildMessage($order);
        $number = preg_replace('/[^0-9]/', '', $this->settings->whatsappNumber());

        return 'https://wa.me/'.$number.'?text='.rawurlencode($message);
    }

    private function buildMessage(Order $order): string
    {
        $storeName = $this->settings->storeName();
        $lines = [];

        $lines[] = "🎁 *{$storeName}* - طلب جديد";
        $lines[] = '';
        $lines[] = "📋 *رقم الطلب:* {$order->order_number}";
        $lines[] = "🛍️ *نوع الطلب:* {$order->order_type->label()}";

        if (! empty($order->customer_name)) {
            $lines[] = "👤 *الاسم:* {$order->customer_name}";
        }
        if (! empty($order->customer_phone)) {
            $lines[] = "📱 *الهاتف:* {$order->customer_phone}";
        }
        if (! empty($order->customer_address)) {
            $lines[] = "📍 *العنوان:* {$order->customer_address}";
        }
        if (! empty($order->customer_notes)) {
            $lines[] = "📝 *ملاحظات:* {$order->customer_notes}";
        }

        $lines[] = '';
        $lines[] = '*تفاصيل الطلب:*';

        foreach ($order->items as $item) {
            $lines[] = '';

            if ($item->item_type === ItemType::CustomGiftBox) {
                $lines[] = '✨ *صندوق هدايا مخصص*';
                $customization = $item->customization_data ?? [];

                if (! empty($customization['products'])) {
                    $lines[] = '   *المنتجات المختارة:*';
                    foreach ($customization['products'] as $product) {
                        $lines[] = "   • {$product['name']} × {$product['quantity']} ({$product['line_total']} ج.م)";
                    }
                }

                if (! empty($customization['personal_message'])) {
                    $lines[] = "   💬 *الرسالة الشخصية:* {$customization['personal_message']}";
                }

                if (! empty($customization['packaging_name'])) {
                    $lines[] = "   📦 *التغليف:* {$customization['packaging_name']} (+{$customization['packaging_cost']} ج.م)";
                }
            } else {
                $lines[] = "• *{$item->name_snapshot}* × {$item->quantity} = {$item->total_price} ج.م";
            }
        }

        $lines[] = '';
        $lines[] = '─────────────────';
        $lines[] = "💰 *المجموع الفرعي:* {$order->subtotal} ج.م";

        if ((float) $order->packaging_cost > 0) {
            $lines[] = "📦 *تكلفة التغليف:* {$order->packaging_cost} ج.م";
        }

        $lines[] = "🏷️ *الإجمالي:* {$order->total} ج.م";
        $lines[] = '🚚 *تكلفة التوصيل:* تحدد خلال المحادثة';
        $lines[] = '';
        $lines[] = '---';
        $lines[] = 'سأقوم بإرسال بيانات التوصيل والتفاصيل الإضافية في هذه المحادثة.';

        return implode("\n", $lines);
    }
}
