@extends('layouts.app')

@section('title', 'تم استلام طلبك بنجاح')
@section('meta_description', 'تم تسجيل طلبك بنجاح في متجر جيفتلي. يرجى متابعة محادثة واتساب لتأكيد الشحن والتفاصيل.')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    {{-- Confirmation Hero Banner --}}
    <div class="card p-8 sm:p-12 text-center mb-8 bg-gradient-to-b from-white to-pink-50/40 border-pink-200">
        <div class="w-20 h-20 mx-auto mb-4 rounded-full flex items-center justify-center text-4xl shadow-md text-white"
             style="background: linear-gradient(135deg, #25D366, #128C7E);">
            ✓
        </div>

        <h1 class="text-2xl sm:text-3xl font-black text-gray-900 mb-2">
            تم إنشاء طلبك بنجاح ❤️
        </h1>

        <div class="my-4">
            <span class="inline-flex items-center gap-2 bg-white px-6 py-2.5 rounded-2xl border-2 border-brand-200 shadow-sm">
                <span class="text-xs font-bold text-gray-500">رقم الطلب:</span>
                <span class="font-mono font-black text-brand-600 text-xl sm:text-2xl tracking-wider select-all" dir="ltr">
                    #{{ $order->order_number }}
                </span>
            </span>
        </div>

        <span class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-800 border border-amber-200 mb-5">
            ⏳ الحالة: {{ $order->status->label() }}
        </span>

        <p class="text-sm text-gray-700 max-w-lg mx-auto mb-6 leading-relaxed">
            اضغط على الزر أدناه للتواصل معنا عبر واتساب وإرسال <strong>الصور والرسائل</strong> وأي تفاصيل ترغب في تخصيصها للبوكس، وسيتم حفظها مباشرة مع رقم طلبك.
        </p>

        {{-- WhatsApp Continuation Button --}}
        <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
            <a href="{{ $whatsappUrl }}"
               target="_blank"
               class="btn-primary text-base sm:text-lg py-4 px-8 shadow-xl flex items-center justify-center gap-3 w-full sm:w-auto font-black hover:scale-102 transition-transform"
               style="background: linear-gradient(135deg, #25D366, #128C7E)">
                <span class="text-2xl">💬</span>
                <span>تواصل معنا على WhatsApp لإرسال الصور والرسائل</span>
                <span>←</span>
            </a>
            <a href="{{ route('home') }}" class="btn-secondary text-sm py-3.5 px-6 w-full sm:w-auto text-center font-bold">
                العودة للرئيسية
            </a>
        </div>
    </div>

    {{-- Order Details Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

        {{-- Order Items (2 cols) --}}
        <div class="md:col-span-2 card p-6">
            <h2 class="text-base font-bold text-gray-900 border-b border-gray-100 pb-3 mb-4 flex items-center gap-2">
                <span>📦</span> تفاصيل محتويات الطلب
            </h2>

            <div class="divide-y divide-gray-100 space-y-3">
                @foreach($order->items as $item)
                    <div class="pt-3 first:pt-0">
                        <div class="flex items-center justify-between text-sm mb-1">
                            <span class="font-bold text-gray-800">
                                {{ $item->name_snapshot }}
                                <span class="text-xs text-gray-500 mr-1">(× {{ $item->quantity }})</span>
                            </span>
                            <span class="font-bold text-gray-900">{{ number_format($item->total_price, 2) }} ج.م</span>
                        </div>

                        {{-- If custom gift box details --}}
                        @if($item->item_type === \App\Enums\ItemType::CustomGiftBox && !empty($item->customization_data))
                            @php $custom = $item->customization_data; @endphp
                            <div class="mt-2 bg-gray-50 p-3 rounded-xl text-xs space-y-1 text-gray-600 border border-gray-100">
                                @if(!empty($custom['packaging_name']))
                                    <div class="flex justify-between">
                                        <span><strong>التغليف:</strong> {{ $custom['packaging_name'] }}</span>
                                        <span class="text-brand-600">+{{ $custom['packaging_cost'] ?? 0 }} ج.م</span>
                                    </div>
                                @endif

                                @if(!empty($custom['products']))
                                    <div class="pt-1">
                                        <span class="font-semibold block text-gray-700 mb-1">المنتجات المختارة داخل الصندوق:</span>
                                        <ul class="list-disc list-inside space-y-0.5 text-gray-600 pl-1">
                                            @foreach($custom['products'] as $p)
                                                <li>{{ $p['name'] }} × {{ $p['quantity'] }} ({{ $p['line_total'] }} ج.م)</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                @if(!empty($custom['personal_message']))
                                    <div class="pt-2 border-t border-gray-200 mt-2">
                                        <strong>💌 بطاقة الإهداء:</strong>
                                        <p class="italic text-gray-700 mt-0.5 bg-white p-2 rounded border border-gray-200">{{ $custom['personal_message'] }}</p>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            {{-- Totals --}}
            <div class="border-t border-gray-100 mt-6 pt-4 space-y-2 text-xs sm:text-sm">
                <div class="flex justify-between text-gray-600">
                    <span>المجموع الفرعي:</span>
                    <span class="font-bold text-gray-800">{{ number_format($order->subtotal, 2) }} ج.م</span>
                </div>
                @if((float) $order->packaging_cost > 0)
                <div class="flex justify-between text-gray-600">
                    <span>تكلفة التغليف الإضافي:</span>
                    <span class="font-bold text-gray-800">{{ number_format($order->packaging_cost, 2) }} ج.م</span>
                </div>
                @endif
                <div class="flex justify-between text-gray-600">
                    <span>تكلفة الشحن والتوصيل:</span>
                    <span class="font-bold text-brand-600">تحدد في محادثة واتساب</span>
                </div>
                <div class="border-t border-dashed border-gray-200 pt-3 flex justify-between items-center text-base font-extrabold text-gray-900">
                    <span>المجموع الإجمالي:</span>
                    <span class="text-xl text-brand-600">{{ number_format($order->total, 2) }} ج.م</span>
                </div>
            </div>
        </div>

        {{-- Customer Info & Next Steps (1 col) --}}
        <div class="space-y-6">
            {{-- Customer Card --}}
            <div class="card p-6 text-xs space-y-3">
                <h3 class="font-bold text-gray-900 text-sm border-b border-gray-100 pb-2 flex items-center gap-1.5">
                    <span>👤</span> بيانات المستلم
                </h3>

                @if($order->customer_name)
                    <div>
                        <span class="text-gray-400 block">الاسم:</span>
                        <span class="font-semibold text-gray-800">{{ $order->customer_name }}</span>
                    </div>
                @endif

                @if($order->customer_phone)
                    <div>
                        <span class="text-gray-400 block">رقم الهاتف:</span>
                        <span class="font-semibold text-gray-800" dir="ltr">{{ $order->customer_phone }}</span>
                    </div>
                @endif

                @if($order->customer_address)
                    <div>
                        <span class="text-gray-400 block">العنوان:</span>
                        <span class="font-semibold text-gray-800">{{ $order->customer_address }}</span>
                    </div>
                @endif

                @if($order->customer_notes)
                    <div>
                        <span class="text-gray-400 block">الملاحظات:</span>
                        <span class="italic text-gray-700 bg-gray-50 p-2 rounded block border border-gray-100">{{ $order->customer_notes }}</span>
                    </div>
                @endif
            </div>

            {{-- How it works next --}}
            <div class="card p-6 bg-brand-50/40 border-brand-200 text-xs space-y-3">
                <h3 class="font-bold text-brand-700 text-sm">ماذا يحدث بعد ذلك؟</h3>
                <div class="space-y-3">
                    <div class="flex items-start gap-2.5">
                        <span class="w-5 h-5 rounded-full bg-brand-500 text-white flex items-center justify-center font-bold text-[10px] shrink-0 mt-0.5">1</span>
                        <p class="text-gray-700">تفتح محادثة واتساب وترسل الصور والرسائل مع رقم طلبك (<strong>#{{ $order->order_number }}</strong>).</p>
                    </div>
                    <div class="flex items-start gap-2.5">
                        <span class="w-5 h-5 rounded-full bg-brand-500 text-white flex items-center justify-center font-bold text-[10px] shrink-0 mt-0.5">2</span>
                        <p class="text-gray-700">يقوم فريقنا بربط الصور والرسائل بملف طلبك والبدء في تجهيز وتصميم البوكس فوراً.</p>
                    </div>
                    <div class="flex items-start gap-2.5">
                        <span class="w-5 h-5 rounded-full bg-brand-500 text-white flex items-center justify-center font-bold text-[10px] shrink-0 mt-0.5">3</span>
                        <p class="text-gray-700">يتم إخطارك بمجرد جاهزية البوكس وتوصيله إلى عنوان المستلم بكل أناقة!</p>
                    </div>
                </div>
            </div>
            {{-- Quick Review Form on Order Confirmation --}}
            <div class="card p-6 text-xs space-y-3 bg-white border-brand-200">
                <h3 class="font-bold text-gray-900 text-sm border-b border-gray-100 pb-2 flex items-center justify-between">
                    <span>⭐ كيف كانت تجربة طلبك؟</span>
                </h3>
                <p class="text-gray-500">رأيك يهمنا ويسعدنا دائماً لمواصلة تقديم أفضل تجربة إهداء.</p>

                <form action="{{ route('reviews.store') }}" method="POST" class="space-y-3 pt-1">
                    @csrf
                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                    <input type="hidden" name="customer_name" value="{{ $order->customer_name ?? 'عميل جيفتلي' }}">

                    <div>
                        <label class="block text-[11px] font-semibold text-gray-700 mb-1">التقييم:</label>
                        <select name="rating" class="input-field text-xs py-1.5">
                            <option value="5">⭐⭐⭐⭐⭐ ممتاز (5 نجوم)</option>
                            <option value="4">⭐⭐⭐⭐ جيد جداً (4 نجوم)</option>
                            <option value="3">⭐⭐⭐ جيد (3 نجوم)</option>
                            <option value="2">⭐⭐ مقبول (2 نجوم)</option>
                            <option value="1">⭐ ضعيف (1 نجمة)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[11px] font-semibold text-gray-700 mb-1">تعليقك أو رسالتك لنا:</label>
                        <textarea name="comment" rows="2" placeholder="اكتب رأيك أو اقتراحك هنا..." class="input-field text-xs py-1.5"></textarea>
                    </div>

                    <button type="submit" class="btn-primary text-xs py-2 w-full justify-center">
                        إرسال التقييم
                    </button>
                </form>
            </div>
        </div>

    </div>

</div>
@endsection
