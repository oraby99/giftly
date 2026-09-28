@extends('layouts.app')

@section('title', 'سلة المشتريات')
@section('meta_description', 'راجع مشترياتك وأكمل طلبك بكل سهولة عبر محادثة واتساب المباشرة.')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10" x-data="cartCheckout()" x-cloak>

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-xs text-gray-500 mb-6">
        <a href="{{ route('home') }}" class="hover:text-brand-600 transition-colors">الرئيسية</a>
        <span>/</span>
        <span class="text-gray-800 font-semibold">سلة المشتريات</span>
    </nav>

    {{-- Page Header --}}
    <div class="flex items-center justify-between border-b border-gray-100 pb-5 mb-8">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 flex items-center gap-2">
                <span>🛒</span> سلة المشتريات
            </h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">
                لديك <span class="font-bold text-brand-600" x-text="$store.cart.count"></span> عناصر في سلتك
            </p>
        </div>

        <button x-show="$store.cart.items.length > 0"
                @click="if (confirm('هل أنت متأكد من رغبتك في إفراغ السلة؟')) $store.cart.clear()"
                class="text-xs text-red-500 hover:text-red-700 hover:bg-red-50 px-3 py-1.5 rounded-lg border border-red-200 transition-colors">
            🗑️ إفراغ السلة
        </button>
    </div>

    {{-- EMPTY STATE --}}
    <div x-show="$store.cart.items.length === 0" class="py-16 text-center card p-8 max-w-xl mx-auto">
        <div class="w-24 h-24 mx-auto mb-5 rounded-full bg-brand-50 flex items-center justify-center text-4xl shadow-inner">
            🛍️
        </div>
        <h2 class="text-xl font-bold text-gray-800 mb-2">سلتك فارغة حالياً</h2>
        <p class="text-sm text-gray-500 max-w-sm mx-auto mb-8 leading-relaxed">
            لم تقم بإضافة أي هدايا أو منتجات بعد. استكشف مجموعتنا الرائعة وصمم هديتك المثالية الآن!
        </p>
        <div class="flex flex-wrap items-center justify-center gap-3">
            <a href="{{ route('gift-boxes.index') }}" class="btn-primary text-sm">
                <span>🎁 تصفح صناديق الهدايا</span>
            </a>
            <a href="{{ route('custom-box-builder') }}" class="btn-secondary text-sm">
                <span>✨ اصنع صندوقك الخاص</span>
            </a>
            <a href="{{ route('products.index') }}" class="btn-secondary text-sm">
                <span>تصفح المنتجات</span>
            </a>
        </div>
    </div>

    {{-- CART CONTENT (Items + Checkout Form) --}}
    <div x-show="$store.cart.items.length > 0" class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

        {{-- Left 2 Cols: Cart Items List --}}
        <div class="lg:col-span-2 space-y-4">

            <template x-for="(item, index) in $store.cart.items" :key="index">
                <div class="card p-5 transition-all hover:border-brand-200 relative">

                    {{-- Item Header: Type Tag & Delete Button --}}
                    <div class="flex items-center justify-between mb-3 border-b border-gray-100 pb-2">
                        <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full"
                              :class="{
                                  'bg-pink-100 text-pink-700': item.type === 'custom_gift_box',
                                  'bg-purple-100 text-purple-700': item.type === 'gift_box',
                                  'bg-blue-100 text-blue-700': item.type === 'product'
                              }"
                              x-text="item.type === 'custom_gift_box' ? '✨ صندوق مخصص' : (item.type === 'gift_box' ? '🎁 صندوق جاهز' : '📦 منتج فردي')">
                        </span>

                        <button @click="$store.cart.remove(index)"
                                title="حذف من السلة"
                                class="text-gray-400 hover:text-red-500 transition-colors p-1 text-sm">
                            ✕ حذف
                        </button>
                    </div>

                    {{-- Item Body --}}
                    <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center justify-between">

                        <div class="flex items-center gap-3.5 flex-1">
                            <div class="w-16 h-16 rounded-xl bg-gray-100 overflow-hidden shrink-0 flex items-center justify-center border border-gray-200 relative">
                                <template x-if="item.image">
                                    <img :src="typeof formatImageUrl === 'function' ? formatImageUrl(item.image) : (item.image.startsWith('/storage') || item.image.startsWith('http') ? item.image : '/storage/' + item.image)"
                                         :alt="item.name"
                                         class="w-full h-full object-cover"
                                         onerror="this.style.display='none'; if(this.parentElement.querySelector('.cart-fallback')) this.parentElement.querySelector('.cart-fallback').style.display='flex';">
                                </template>
                                <div class="cart-fallback w-full h-full flex items-center justify-center text-2xl text-gray-400"
                                     :style="item.image ? 'display: none;' : 'display: flex;'">
                                    🎁
                                </div>
                            </div>

                            <div class="space-y-1">
                                <h3 class="font-bold text-gray-900 text-sm sm:text-base" x-text="item.name"></h3>
                                <div class="text-xs text-brand-600 font-semibold"
                                     x-text="parseFloat(item.price || item.unit_price).toFixed(2) + ' ج.م'"></div>
                            </div>
                        </div>

                        {{-- Quantity & Line Total --}}
                        <div class="flex items-center justify-between sm:justify-end gap-6 w-full sm:w-auto pt-3 sm:pt-0 border-t sm:border-t-0 border-gray-100">
                            {{-- Qty controller (only for standard products and gift boxes) --}}
                            <template x-if="item.type !== 'custom_gift_box'">
                                <div class="flex items-center border border-gray-200 rounded-lg bg-gray-50 overflow-hidden">
                                    <button type="button"
                                            @click="$store.cart.updateQuantity(index, item.quantity - 1)"
                                            class="w-8 h-8 flex items-center justify-center text-gray-600 hover:bg-gray-200 transition-colors text-sm font-bold">
                                        -
                                    </button>
                                    <span class="w-8 text-center text-xs font-bold text-gray-800" x-text="item.quantity"></span>
                                    <button type="button"
                                            @click="$store.cart.updateQuantity(index, item.quantity + 1)"
                                            class="w-8 h-8 flex items-center justify-center text-gray-600 hover:bg-gray-200 transition-colors text-sm font-bold">
                                        +
                                    </button>
                                </div>
                            </template>

                            <template x-if="item.type === 'custom_gift_box'">
                                <span class="text-xs text-gray-400 font-medium">الكمية: 1</span>
                            </template>

                            <div class="text-right">
                                <span class="text-xs text-gray-400 block">الإجمالي</span>
                                <span class="text-sm sm:text-base font-extrabold text-gray-900"
                                      x-text="((parseFloat(item.price || item.unit_price)) * (item.quantity || 1)).toFixed(2) + ' ج.م'">
                                </span>
                            </div>
                        </div>

                    </div>

                    {{-- Custom Gift Box Nested Details (Products inside & message) --}}
                    <template x-if="item.type === 'custom_gift_box'">
                        <div class="mt-4 pt-3 border-t border-dashed border-gray-200 text-xs space-y-2 bg-gray-50/70 p-3 rounded-xl">
                            <div class="flex flex-wrap items-center justify-between text-gray-600">
                                <span><strong>📦 نوع العلبة:</strong> <span x-text="item.packaging_name || 'صندوق قياسي'"></span></span>
                                <span class="text-brand-600" x-show="item.packaging_cost > 0" x-text="'+' + item.packaging_cost + ' ج.م'"></span>
                            </div>

                            <div x-show="item.occasion">
                                <strong>المناسبة:</strong> <span x-text="item.occasion"></span>
                            </div>

                            <div>
                                <strong class="block mb-1 text-gray-700">محتويات الصندوق:</strong>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-1.5 pl-2">
                                    <template x-for="p in item.products" :key="p.product_id">
                                        <div class="flex items-center justify-between text-[11px] text-gray-600 bg-white px-2 py-1 rounded border border-gray-100">
                                            <span x-text="'• ' + p.name + ' × ' + p.quantity"></span>
                                            <span class="font-bold text-gray-800" x-text="(p.price * p.quantity).toFixed(2) + ' ج.م'"></span>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            <div x-show="item.personal_message" class="pt-1">
                                <strong class="text-gray-700">💌 الرسالة الشخصية:</strong>
                                <p class="italic text-gray-600 mt-0.5 bg-white p-2 rounded border border-brand-100" x-text="item.personal_message"></p>
                            </div>
                        </div>
                    </template>

                </div>
            </template>

            {{-- Continue Shopping Link --}}
            <div class="pt-4 flex items-center justify-between">
                <a href="{{ route('products.index') }}" class="text-xs font-semibold text-brand-600 hover:text-brand-700 flex items-center gap-1">
                    <span>→</span> متابعة التسوق وإضافة المزيد
                </a>
            </div>

        </div>

        {{-- Right Col: Order Summary & Checkout Form --}}
        <div class="space-y-6">

            <div class="card p-6 sticky top-24">
                <h3 class="text-lg font-bold text-gray-900 border-b border-gray-100 pb-3 mb-4 flex items-center gap-2">
                    <span>📋</span> ملخص الطلب
                </h3>

                {{-- Price Calculations --}}
                <div class="space-y-2.5 text-xs sm:text-sm border-b border-gray-100 pb-4 mb-4">
                    <div class="flex justify-between text-gray-600">
                        <span>المجموع الفرعي:</span>
                        <span class="font-bold text-gray-800" x-text="$store.cart.subtotal.toFixed(2) + ' ج.م'"></span>
                    </div>

                    <div class="flex justify-between text-gray-600">
                        <span>مصاريف التوصيل:</span>
                        <span class="font-bold text-brand-600">تحدد في محادثة واتساب</span>
                    </div>

                    <div class="border-t border-dashed border-gray-200 pt-3 flex justify-between items-center font-extrabold text-base text-gray-900">
                        <span>المجموع الكلي:</span>
                        <span class="text-xl text-brand-600" x-text="$store.cart.subtotal.toFixed(2) + ' ج.م'"></span>
                    </div>
                </div>

                {{-- Customer Information Form (For WhatsApp dispatch) --}}
                <div class="space-y-3.5 mb-5">
                    <h4 class="text-xs font-bold text-gray-800 uppercase tracking-wider flex items-center gap-1.5">
                        <span>👤</span> بيانات المستلم للتوصيل
                    </h4>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">الاسم بالكامل <span class="text-red-500">*</span></label>
                        <input type="text"
                               x-model="customerName"
                               placeholder="اسمك أو اسم مستلم الهدية"
                               class="input-field text-xs py-2">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">رقم الهاتف / الواتساب <span class="text-red-500">*</span></label>
                        <input type="tel"
                               x-model="customerPhone"
                               placeholder="010xxxxxxxx"
                               class="input-field text-xs py-2"
                               dir="ltr">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">عنوان التوصيل بالتفصيل</label>
                        <input type="text"
                               x-model="customerAddress"
                               placeholder="المحافظة، المنطقة، اسم الشارع، رقم العمارة"
                               class="input-field text-xs py-2">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">ملاحظات إضافية أو تاريخ التسليم المطلوب</label>
                        <textarea x-model="customerNotes"
                                  rows="2"
                                  placeholder="أي تفاصيل خاصة بتوقيت التوصيل أو طريقة التسليم المفضلة..."
                                  class="input-field text-xs py-1.5"></textarea>
                    </div>
                </div>

                {{-- Error Message Display --}}
                <div x-show="errorMessage" class="mb-4 p-3 bg-red-50 border border-red-200 rounded-xl text-xs text-red-600 leading-relaxed" x-text="errorMessage"></div>

                {{-- Submit Order via WhatsApp Button --}}
                <button type="button"
                        @click="submitOrder()"
                        :disabled="isSubmitting"
                        class="w-full btn-primary justify-center text-sm sm:text-base py-3.5 shadow-md flex items-center gap-2 group transition-all"
                        style="background: linear-gradient(135deg, #25D366, #128C7E)">
                    <span x-show="!isSubmitting" class="text-lg">💬</span>
                    <span x-show="!isSubmitting">إتمام الطلب عبر واتساب</span>
                    <span x-show="isSubmitting" class="animate-spin text-sm">⏳</span>
                    <span x-show="isSubmitting">جارٍ إنشاء الطلب...</span>
                </button>

                <div class="mt-4 p-3 bg-gray-50 rounded-xl border border-gray-100 text-[11px] text-gray-500 space-y-1.5 leading-relaxed">
                    <div class="flex items-center gap-1.5 text-gray-700 font-semibold">
                        <span>🛡️</span> بدون دفع إلكتروني
                    </div>
                    <p>
                        سيتم حفظ طلبك في النظام فوراً، ثم فتح تطبيق واتساب مباشرة للتأكيد مع خدمة العملاء وتحديد موعد وطريقة الدفع والتوصيل.
                    </p>
                </div>
            </div>

        </div>

    </div>

</div>

<script>
function cartCheckout() {
    return {
        customerName: '',
        customerPhone: '',
        customerAddress: '',
        customerNotes: '',
        isSubmitting: false,
        errorMessage: '',

        init() {
            // Repair any legacy/malformed image paths in already stored cart items
            try {
                const cart = Alpine.store('cart');
                if (cart && Array.isArray(cart.items)) {
                    let updated = false;
                    cart.items.forEach(item => {
                        if (item.image && typeof window.formatImageUrl === 'function') {
                            const formatted = window.formatImageUrl(item.image);
                            if (formatted !== item.image) {
                                item.image = formatted;
                                updated = true;
                            }
                        }
                    });
                    if (updated) {
                        cart.save();
                    }
                }
            } catch (e) {
                console.error('Cart image init error:', e);
            }
        },

        async submitOrder() {
            const items = Alpine.store('cart').items;

            if (!items || items.length === 0) {
                this.errorMessage = 'سلة المشتريات فارغة.';
                return;
            }

            if (!this.customerName.trim()) {
                this.errorMessage = 'يرجى كتابة الاسم للمتابعة.';
                return;
            }

            if (!this.customerPhone.trim()) {
                this.errorMessage = 'يرجى كتابة رقم الهاتف / الواتساب.';
                return;
            }

            this.isSubmitting = true;
            this.errorMessage = '';

            try {
                // Map items into PlaceOrderRequest format
                const formattedItems = items.map(item => {
                    if (item.type === 'custom_gift_box') {
                        return {
                            type: 'custom_gift_box',
                            quantity: 1,
                            packaging_option_id: item.packaging_option_id || null,
                            occasion: item.occasion || null,
                            recipient_type: item.recipient_type || null,
                            personal_message: item.personal_message || null,
                            products: (item.products || []).map(p => ({
                                product_id: p.product_id,
                                quantity: p.quantity,
                            })),
                        };
                    } else if (item.type === 'gift_box') {
                        return {
                            type: 'gift_box',
                            gift_box_id: item.gift_box_id,
                            quantity: item.quantity || 1,
                        };
                    } else {
                        return {
                            type: 'product',
                            product_id: item.product_id,
                            quantity: item.quantity || 1,
                        };
                    }
                });

                const payload = {
                    items: formattedItems,
                    customer_name: this.customerName,
                    customer_phone: this.customerPhone,
                    customer_address: this.customerAddress,
                    customer_notes: this.customerNotes,
                };

                const res = await fetch("{{ route('orders.store') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify(payload),
                });

                const data = await res.json();

                if (!res.ok) {
                    throw new Error(data.message || 'حدث خطأ أثناء معالجة الطلب، يرجى المحاولة مرة أخرى.');
                }

                // Clear cart from local storage
                Alpine.store('cart').clear();

                // Open WhatsApp in a new tab if URL provided
                if (data.whatsapp_url) {
                    window.open(data.whatsapp_url, '_blank');
                }

                // Redirect user to confirmation page
                if (data.confirmation_url) {
                    window.location.href = data.confirmation_url;
                } else {
                    window.location.href = `/orders/${data.order_number}/confirmation`;
                }

            } catch (err) {
                console.error(err);
                this.errorMessage = err.message || 'حدث خطأ في إرسال الطلب. يرجى مراجعة البيانات والمحاولة مجدداً.';
            } finally {
                this.isSubmitting = false;
            }
        }
    };
}
</script>
@endsection
