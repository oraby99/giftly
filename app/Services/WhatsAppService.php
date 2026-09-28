<?php

namespace App\Services;

use App\Enums\ItemType;
use App\Models\GiftBox;
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

    public function generateGiftBoxUrl(GiftBox $giftBox, ?string $boxDisplayName = null): string
    {
        $cleanName = $boxDisplayName ?: trim(str_replace(['بوكس', 'صندوق', '❤️', '«', '»'], '', $giftBox->name));
        if (empty($cleanName)) {
            $cleanName = $giftBox->name;
        }

        $lines = [];
        $lines[] = 'أهلاً بيك ❤️';
        $lines[] = "بوكس «{$cleanName}» بيتعمل مخصوص للشخص اللي هتهديهوله، وبيضم صوركم ورسائلكم بطريقة شخصية جدًا.";
        $lines[] = 'تحب أشوفك محتويات البوكس والأسعار؟ 🎁';
        $lines[] = 'أيوه، حابب أعرف محتويات البوكس والأسعار ✨';
        $lines[] = '';
        $lines[] = '📦 *محتويات البوكس:*';

        if ($giftBox->items->isNotEmpty()) {
            foreach ($giftBox->items as $index => $item) {
                $num = $index + 1;
                $lines[] = "{$num}. {$item->product?->name}";
            }
        } else {
            $lines[] = '1. رسالة من قلبي ليك';
            $lines[] = '2. برطمان مواقف ورسائل صغيرة بتقول كتير';
            $lines[] = '3. برواز ذكرياتنا الحلوة لطباعة الصور';
            $lines[] = '4. مج مخصص وكارت إهداء';
        }

        $lines[] = '';
        $lines[] = '💰 *السعر:* '.number_format((float) $giftBox->price, 2).' ج.م';
        $lines[] = '';
        $lines[] = "+ عشان نبدأ نجهز بوكس «{$cleanName}» بتفاصيله الخاصة بيكم، محتاجين منك:";
        $lines[] = '';
        $lines[] = '📸 *الصور:* من 5 إلى 10 صور تحب تضيفها للبوكس.';
        $lines[] = '';
        $lines[] = '💌 *الرسائل:* ابعتلنا الرسائل اللي حابب نحطها، سواء رسالة واحدة طويلة أو أكتر من رسالة قصيرة وممكن نساعدك لو حتي الكلام اللي هتقوله مش مرتب ♥️';
        $lines[] = '';
        $lines[] = '🎁 ولو عندك أي طلب خاص في التصميم أو ترتيب الصور والرسائل، اكتبهولنا.';
        $lines[] = '';
        $lines[] = 'ممكن تبعت الصور والرسائل هنا على الواتساب مباشرة، وإحنا هنرتبهم ونجهز التصميم ليك ❤️';
        $lines[] = '';
        $lines[] = 'ملحوظة: يفضل إرسال الصور بجودتها الأصلية عشان نطلعها بأفضل جودة ممكنة.';

        $message = implode("\n", $lines);
        $number = preg_replace('/[^0-9]/', '', $this->settings->whatsappNumber());

        return 'https://wa.me/'.$number.'?text='.rawurlencode($message);
    }

    private function buildMessage(Order $order): string
    {
        $storeName = $this->settings->storeName();
        $lines = [];

        $lines[] = "أهلاً {$storeName} ❤️";
        $lines[] = 'قمت بإنشاء الطلب بنجاح عبر الموقع:';
        $lines[] = '';
        $lines[] = "📋 *رقم الطلب:* #{$order->order_number}";

        if (! empty($order->customer_name)) {
            $lines[] = "👤 *اسم العميل:* {$order->customer_name}";
        }
        if (! empty($order->customer_phone)) {
            $lines[] = "📱 *رقم الهاتف:* {$order->customer_phone}";
        }
        if (! empty($order->customer_address)) {
            $lines[] = "📍 *عنوان التوصيل:* {$order->customer_address}";
        }
        if (! empty($order->customer_notes)) {
            $lines[] = "📝 *ملاحظات خاصة:* {$order->customer_notes}";
        }

        $lines[] = '';
        $lines[] = '📦 *تفاصيل محتويات الطلب:*';

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
        $lines[] = '🚚 *الشحن:* يحدد حسب العنوان والمحافظة';
        $lines[] = '';
        $lines[] = '📸 *جاهز لإرسال الصور والرسائل والتفاصيل الخاصة بالبوكس لمتابعة تجهيز الطلب فوراً.*';

        return implode("\n", $lines);
    }
}
