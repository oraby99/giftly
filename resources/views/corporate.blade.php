@extends('layouts.app')

@section('title', 'هدايا الشركات والمؤسسات')
@section('meta_description', 'حلول هدايا شركات متكاملة، تخصيص الهوية البصرية، أسعار خاصة للكميات وشحن لجميع محافظات مصر.')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Hero Section --}}
    <div class="card p-8 sm:p-14 text-center mb-16 relative overflow-hidden bg-gradient-to-br from-white via-brand-50/40 to-pink-50 border-brand-200">
        <div class="max-w-3xl mx-auto relative z-10">
            <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-xs font-semibold bg-brand-100 text-brand-700 mb-4">
                🏢 خدمات B2B وهدايا الشركات
            </span>
            <h1 class="text-3xl sm:text-5xl font-extrabold text-gray-900 mb-4 leading-tight">
                هدايا شركات استثنائية <span style="color: oklch(0.58 0.165 345)">ترسخ علاقاتك</span> وتخلد علامتك
            </h1>
            <p class="text-sm sm:text-base text-gray-600 mb-8 leading-relaxed">
                سواء كنت تحتفل بنجاح فريق العمل، ترحب بموظفيك الجدد، أو تقدم تقديراً لشركائك وعملائك في المناسبات والأعياد، نصمم لك صناديق هدايا فاخرة تعكس هوية شركتك بأعلى درجات الرقي.
            </p>
            <div class="flex flex-wrap items-center justify-center gap-4">
                <a href="#inquiry-form" class="btn-primary text-sm sm:text-base py-3 px-8 shadow-md">
                    <span>📝 طلب عرض أسعار مخصص</span>
                </a>
                <a href="https://wa.me/201112126939?text={{ rawurlencode('مرحباً، أود الاستفسار عن باقات هدايا الشركات من جيفتلي') }}"
                   target="_blank"
                   class="btn-secondary text-sm sm:text-base py-3 px-6 flex items-center gap-2">
                    <span class="text-green-600">💬</span>
                    <span>محادثة واتساب مبيعات الشركات</span>
                </a>
            </div>
        </div>
    </div>

    {{-- Value Propositions / Features --}}
    <div class="mb-16">
        <div class="text-center max-w-xl mx-auto mb-10">
            <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 mb-2">لماذا تختار جيفتلي لهدايا شركتك؟</h2>
            <p class="text-xs sm:text-sm text-gray-500">نقدم تجربة متكاملة من الألف إلى الياء بأعلى معايير الاحترافية</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="card p-6 text-center hover:border-brand-300 transition-all">
                <div class="w-14 h-14 mx-auto mb-4 rounded-2xl bg-brand-50 flex items-center justify-center text-2xl">
                    🎨
                </div>
                <h3 class="font-bold text-gray-900 text-base mb-2">تخصيص بالهوية والشعار</h3>
                <p class="text-xs text-gray-500 leading-relaxed">
                    طباعة شعار شركتك على الصندوق والشرائط وبطاقات الإهداء ومحتويات الهدية باحترافية.
                </p>
            </div>

            <div class="card p-6 text-center hover:border-brand-300 transition-all">
                <div class="w-14 h-14 mx-auto mb-4 rounded-2xl bg-brand-50 flex items-center justify-center text-2xl">
                    🏷️
                </div>
                <h3 class="font-bold text-gray-900 text-base mb-2">أسعار خاصة للكميات</h3>
                <p class="text-xs text-gray-500 leading-relaxed">
                    خصومات تصاعدية مجزية تناسب مختلف الميزانيات من الطلبات المتوسطة إلى الضخمة.
                </p>
            </div>

            <div class="card p-6 text-center hover:border-brand-300 transition-all">
                <div class="w-14 h-14 mx-auto mb-4 rounded-2xl bg-brand-50 flex items-center justify-center text-2xl">
                    🚚
                </div>
                <h3 class="font-bold text-gray-900 text-base mb-2">شحن وتوزيع فردي أو جماعي</h3>
                <p class="text-xs text-gray-500 leading-relaxed">
                    إمكانية تسليم الطلبية لمقر الشركة أو شحن كل صندوق مباشرة إلى عنوان كل موظف أو عميل.
                </p>
            </div>

            <div class="card p-6 text-center hover:border-brand-300 transition-all">
                <div class="w-14 h-14 mx-auto mb-4 rounded-2xl bg-brand-50 flex items-center justify-center text-2xl">
                    📑
                </div>
                <h3 class="font-bold text-gray-900 text-base mb-2">فواتير ومعاملات رسمية</h3>
                <p class="text-xs text-gray-500 leading-relaxed">
                    فواتير ضريبية نظامية، اتفاقيات توريد، وتسهيلات دفع مرنة مخصصة للشركات والمؤسسات.
                </p>
            </div>
        </div>
    </div>

    {{-- Corporate Boxes Section --}}
    @if($corporateBoxes->isNotEmpty())
    <div class="mb-16">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-8">
            <div>
                <span class="text-xs font-extrabold text-brand-600 px-3 py-1 rounded-full bg-brand-50 border border-brand-100 inline-block mb-2">
                    🏢 تشكيلة هدايا الشركات والمؤسسات
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900">نماذج وباقات صناديق الشركات</h2>
                <p class="text-xs sm:text-sm text-gray-500 mt-1">باقات متكاملة جاهزة للتخصيص بطباعة شعار وهوية شركتك، أو نصمم لك باقة حصرية حسب ميزانيتك</p>
            </div>
            <a href="https://wa.me/201112126939?text={{ rawurlencode('مرحباً، أرغب في الاستفسار عن تفصيل صناديق هدايا خاصة بشركتنا 🏢') }}"
               target="_blank"
               class="btn-secondary text-xs sm:text-sm py-2.5 px-4 shrink-0">
                <span>💬 تفصيل صندوق خاص</span>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($corporateBoxes as $box)
                <div class="card p-5 group hover:border-brand-300 hover:shadow-lg transition-all flex flex-col justify-between">
                    <div>
                        <div class="aspect-4/3 rounded-2xl bg-gradient-to-br from-gray-50 to-pink-50/40 overflow-hidden mb-4 relative border border-gray-100 flex items-center justify-center">
                            @if($box->image)
                                <img src="{{ Storage::url($box->image) }}" alt="{{ $box->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-gray-400 gap-1">
                                    <span class="text-5xl">🎁</span>
                                    <span class="text-[11px] font-bold text-gray-400">جيفتلي بزنس</span>
                                </div>
                            @endif

                            @if($box->min_quantity)
                            <span class="absolute top-2.5 right-2.5 text-[10px] font-bold text-gray-700 bg-white/95 backdrop-blur-xs px-2.5 py-1 rounded-full shadow-xs border border-gray-100">
                                الحد الأدنى: {{ $box->min_quantity }} علبة
                            </span>
                            @endif
                        </div>

                        <h3 class="font-extrabold text-sm sm:text-base text-gray-900 mb-1.5 leading-snug">{{ $box->name }}</h3>
                        
                        @if($box->description)
                        <p class="text-xs text-gray-500 line-clamp-2 leading-relaxed mb-3">{{ $box->description }}</p>
                        @endif

                        @if(!empty($box->features) && is_array($box->features))
                        <div class="mb-4 pt-2 border-t border-gray-100 space-y-1">
                            @foreach(array_slice($box->features, 0, 3) as $feat)
                            <div class="flex items-center gap-1.5 text-[11px] text-gray-600">
                                <span class="text-brand-500 font-bold">✓</span>
                                <span class="line-clamp-1">{{ is_array($feat) ? ($feat['item'] ?? '') : $feat }}</span>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>

                    <div class="pt-3 border-t border-gray-100 mt-auto">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-[11px] text-gray-400 font-medium">السعر التقديري:</span>
                            @if($box->price)
                            <span class="font-black text-sm text-brand-600 font-mono">
                                يبدأ من {{ number_format($box->price, 0) }} ج.م
                            </span>
                            @else
                            <span class="text-xs font-bold text-gray-600">حسب الكمية</span>
                            @endif
                        </div>

                        <a href="https://wa.me/201112126939?text={{ rawurlencode('مرحباً، أود الاستفسار وطلب عرض أسعار بخصوص: ' . $box->name . ' للشركات 🏢') }}"
                           target="_blank"
                           class="w-full btn-primary py-2 px-3 text-xs justify-center font-bold flex items-center gap-1.5 shadow-sm hover:shadow transition-all">
                            <span>طلب عرض سعر</span>
                            <span>←</span>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Inquiry Form Section --}}
    <div id="inquiry-form" class="max-w-3xl mx-auto card p-6 sm:p-10 border-brand-200">
        <div class="text-center mb-8">
            <span class="text-2xl mb-1 block">📩</span>
            <h2 class="text-2xl font-extrabold text-gray-900 mb-2">طلب عرض أسعار واستشارة هدايا</h2>
            <p class="text-xs sm:text-sm text-gray-500">
                املأ النموذج وسيقوم مدير حسابات الشركات بالتواصل معك خلال ساعات لإعداد العرض المثالي
            </p>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-200 text-green-800 text-xs sm:text-sm text-center">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-800 text-xs sm:text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('corporate.inquiry.store') }}" method="POST" class="space-y-4">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">اسم الشركة / المؤسسة <span class="text-red-500">*</span></label>
                    <input type="text" name="company_name" value="{{ old('company_name') }}" required placeholder="مثال: شركة الأمل للحلول الرقمية" class="input-field text-xs">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">اسم المسؤول / جهة الاتصال <span class="text-red-500">*</span></label>
                    <input type="text" name="contact_person" value="{{ old('contact_person') }}" required placeholder="مثال: أ / أحمد محمود" class="input-field text-xs">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">رقم الهاتف / الواتساب <span class="text-red-500">*</span></label>
                    <input type="tel" name="phone" value="{{ old('phone') }}" required placeholder="010xxxxxxxx" dir="ltr" class="input-field text-xs">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">البريد الإلكتروني للعمل</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="name@company.com" dir="ltr" class="input-field text-xs">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">الكمية التقديرية المطلوبة <span class="text-red-500">*</span></label>
                    <input type="number" name="quantity" min="1" value="{{ old('quantity', 20) }}" required placeholder="مثال: 50" class="input-field text-xs">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">الميزانية التقديرية للصندوق الواحد (ج.م)</label>
                    <input type="number" name="budget" min="0" step="50" value="{{ old('budget') }}" placeholder="مثال: 500" class="input-field text-xs">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">تفاصيل ومناسبات الهدية أو أي متطلبات خاصة</label>
                <textarea name="message" rows="4" placeholder="مثال: هدايا نهاية العام للموظفين مع إضافة شعار الشركة وكوب مطبوع، الموعد المطلوب للتسليم..." class="input-field text-xs">{{ old('message') }}</textarea>
            </div>

            <div class="pt-2">
                <button type="submit" class="btn-primary w-full justify-center text-sm py-3.5 shadow-md">
                    <span>📤 إرسال طلب عرض الأسعار</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
