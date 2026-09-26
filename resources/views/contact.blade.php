@extends('layouts.app')

@section('title', 'تواصل معنا - خدمة عملاء جيفتلي')
@section('meta_description', 'تواصل مع فريق جيفتلي عبر الواتساب أو الهاتف للاستفسار وتنسيق الهدايا والتوصيل السريع.')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12" x-data="{ activeFaq: null }">

    {{-- Header --}}
    <div class="text-center max-w-2xl mx-auto mb-12">
        <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-semibold bg-brand-50 text-brand-600 border border-brand-200 mb-3">
            💬 يسعدنا دائماً سماع صوتك
        </span>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mb-3">
            نحن هنا لمساعدتك في <span style="color: oklch(0.58 0.165 345)">اختيار وتنسيق هديتك</span>
        </h1>
        <p class="text-xs sm:text-sm text-gray-500 leading-relaxed">
            فريق خدمة العملاء متواجد لمساعدتك في اختيار المنتجات، الرد على الاستفسارات، وتنسيق التوصيل الخاص.
        </p>
    </div>

    {{-- Contact Channels Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-16">

        {{-- WhatsApp Card --}}
        <div class="card p-6 text-center border-green-200 bg-green-50/20 hover:border-green-400 transition-all flex flex-col justify-between">
            <div>
                <div class="w-14 h-14 mx-auto mb-4 rounded-2xl flex items-center justify-center text-3xl shadow-sm text-white"
                     style="background: #25D366">
                    💬
                </div>
                <h3 class="font-bold text-gray-900 text-base mb-1">واتساب المباشر</h3>
                <p class="text-xs text-gray-500 mb-4">أسرع وسيلة للتواصل وتأكيد الطلبات وتخصيص الصناديق</p>
            </div>
            <a href="https://wa.me/201112126939?text={{ rawurlencode('مرحباً، لدي استفسار بخصوص متجر جيفتلي') }}"
               target="_blank"
               class="btn-primary text-xs py-2.5 w-full justify-center"
               style="background: linear-gradient(135deg, #25D366, #128C7E)">
                <span>بدء محادثة واتساب</span>
                <span>←</span>
            </a>
        </div>

        {{-- Phone Card --}}
        <div class="card p-6 text-center border-brand-200 bg-brand-50/20 hover:border-brand-400 transition-all flex flex-col justify-between">
            <div>
                <div class="w-14 h-14 mx-auto mb-4 rounded-2xl bg-brand-500 text-white flex items-center justify-center text-2xl shadow-sm">
                    📞
                </div>
                <h3 class="font-bold text-gray-900 text-base mb-1">الاتصال الهاتفي</h3>
                <p class="text-xs text-gray-500 mb-4">متاح يومياً من 10 صباحاً حتى 10 مساءً</p>
            </div>
            <a href="tel:+201112126939"
               class="btn-secondary text-xs py-2.5 w-full justify-center font-bold"
               dir="ltr">
                +20 11 1212 6939
            </a>
        </div>

        {{-- Location / Email Card --}}
        <div class="card p-6 text-center hover:border-brand-200 transition-all flex flex-col justify-between">
            <div>
                <div class="w-14 h-14 mx-auto mb-4 rounded-2xl bg-gray-100 text-gray-700 flex items-center justify-center text-2xl shadow-sm">
                    📍
                </div>
                <h3 class="font-bold text-gray-900 text-base mb-1">الموقع والتغطية</h3>
                <p class="text-xs text-gray-500 mb-4">القاهرة، مصر — نشحن لجميع أنحاء الجمهورية</p>
            </div>
            <div class="text-xs text-gray-500 font-semibold bg-gray-50 py-2.5 rounded-xl border border-gray-100">
                support@giftly.eg
            </div>
        </div>

    </div>

    {{-- FAQs Section --}}
    <div class="max-w-3xl mx-auto mb-16">
        <div class="text-center mb-8">
            <h2 class="text-2xl font-extrabold text-gray-900 mb-2">الأسئلة الأكثر شيوعاً</h2>
            <p class="text-xs sm:text-sm text-gray-500">إجابات سريعة على معظم التساؤلات المتكررة</p>
        </div>

        <div class="space-y-3">
            {{-- FAQ Item 1 --}}
            <div class="card p-4 transition-all">
                <button type="button"
                        @click="activeFaq = activeFaq === 1 ? null : 1"
                        class="w-full flex items-center justify-between font-bold text-gray-900 text-sm text-right focus:outline-none">
                    <span>كيف أقوم بطلب هدية عبر المتجر؟</span>
                    <span class="text-brand-500 text-base transition-transform" :class="activeFaq === 1 ? 'rotate-180' : ''">▾</span>
                </button>
                <div x-show="activeFaq === 1" x-collapse class="mt-3 text-xs text-gray-600 leading-relaxed border-t border-gray-100 pt-3">
                    يمكنك تصفح صناديق الهدايا الجاهزة أو بناء صندوقك المخصص بالكامل عبر "اصنع صندوقك الخاص"، ثم إضافتها للسلة والضغط على "إتمام الطلب عبر واتساب". سيتم حفظ طلبك وفتح محادثة واتساب فوراً مع خدمة العملاء لتأكيد تفاصيل وموعد التوصيل.
                </div>
            </div>

            {{-- FAQ Item 2 --}}
            <div class="card p-4 transition-all">
                <button type="button"
                        @click="activeFaq = activeFaq === 2 ? null : 2"
                        class="w-full flex items-center justify-between font-bold text-gray-900 text-sm text-right focus:outline-none">
                    <span>هل يوجد دفع إلكتروني أو بطاقة ائتمانية؟</span>
                    <span class="text-brand-500 text-base transition-transform" :class="activeFaq === 2 ? 'rotate-180' : ''">▾</span>
                </button>
                <div x-show="activeFaq === 2" x-collapse class="mt-3 text-xs text-gray-600 leading-relaxed border-t border-gray-100 pt-3">
                    لا حاجة لأي بطاقة دفع أونلاين في الموقع! كافة تفاصيل الدفع (مثل فودافون كاش، إنستاباي InstaPay، أو الدفع عند الاستلام) يتم الاتفاق عليها بكل راحة وسهولة مباشرة في محادثة الواتساب مع خدمة العملاء.
                </div>
            </div>

            {{-- FAQ Item 3 --}}
            <div class="card p-4 transition-all">
                <button type="button"
                        @click="activeFaq = activeFaq === 3 ? null : 3"
                        class="w-full flex items-center justify-between font-bold text-gray-900 text-sm text-right focus:outline-none">
                    <span>كم تستغرق عملية تجهيز وتوصيل الهدية؟</span>
                    <span class="text-brand-500 text-base transition-transform" :class="activeFaq === 3 ? 'rotate-180' : ''">▾</span>
                </button>
                <div x-show="activeFaq === 3" x-collapse class="mt-3 text-xs text-gray-600 leading-relaxed border-t border-gray-100 pt-3">
                    تستغرق الطلبات العادية داخل القاهرة والجيزة من 24 إلى 48 ساعة، ويتوفر خيار التوصيل السريع (في نفس اليوم) في حالات معينة يتم تنسيقها عبر واتساب. باقي المحافظات تستغرق من 2 إلى 4 أيام عمل.
                </div>
            </div>

            {{-- FAQ Item 4 --}}
            <div class="card p-4 transition-all">
                <button type="button"
                        @click="activeFaq = activeFaq === 4 ? null : 4"
                        class="w-full flex items-center justify-between font-bold text-gray-900 text-sm text-right focus:outline-none">
                    <span>هل يمكنني إرسال الهدية كـ "مفاجأة" مباشرة إلى المستلم دون إظهار السعر؟</span>
                    <span class="text-brand-500 text-base transition-transform" :class="activeFaq === 4 ? 'rotate-180' : ''">▾</span>
                </button>
                <div x-show="activeFaq === 4" x-collapse class="mt-3 text-xs text-gray-600 leading-relaxed border-t border-gray-100 pt-3">
                    نعم بالتأكيد! هذا من أكثر خدماتنا طلباً. لا نضع أي فواتير أو أسعار داخل الصندوق، ونقوم بتوصيل الهدية مع بطاقة الإهداء بالرسالة الشخصية في التوقيت الذي تفضله كمفاجأة مبهجة.
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
