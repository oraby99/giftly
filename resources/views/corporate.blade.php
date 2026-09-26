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

    {{-- Example Corporate Boxes --}}
    @if($exampleBoxes->isNotEmpty())
    <div class="mb-16">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-xl sm:text-2xl font-extrabold text-gray-900">أفكار ونماذج صناديق جاهزة</h2>
                <p class="text-xs sm:text-sm text-gray-500 mt-1">نماذج يمكنك طلبها كما هي أو تعديلها بالكامل حسب رغبتك</p>
            </div>
            <a href="{{ route('gift-boxes.index') }}" class="text-xs font-bold text-brand-600 hover:text-brand-700 flex items-center gap-1">
                <span>تصفح الكل</span>
                <span>←</span>
            </a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach($exampleBoxes as $box)
                <a href="{{ route('gift-boxes.show', $box->slug) }}" class="card p-3 group hover:border-brand-300 transition-all text-center">
                    <div class="aspect-square rounded-xl bg-gray-100 overflow-hidden mb-2 relative">
                        @if($box->image)
                            <img src="{{ asset('storage/' . $box->image) }}" alt="{{ $box->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-2xl">🎁</div>
                        @endif
                    </div>
                    <h4 class="font-bold text-xs text-gray-800 line-clamp-1 mb-1">{{ $box->name }}</h4>
                    <span class="text-xs font-bold text-brand-600">{{ number_format($box->price, 0) }} ج.م</span>
                </a>
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
