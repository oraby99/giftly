@extends('layouts.app')

@section('title', 'من نحن - قصة جيفتلي')
@section('meta_description', 'تعرف على قصة جيفتلي، متجر الهدايا الرائد في مصر لصناديق الهدايا الفاخرة والتجارب المخصصة.')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    {{-- Hero Section --}}
    <div class="text-center max-w-3xl mx-auto mb-16">
        <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-semibold bg-brand-50 text-brand-600 border border-brand-200 mb-3">
            🎁 نصنع ذكريات لا تُنسى
        </span>
        <h1 class="text-3xl sm:text-5xl font-extrabold text-gray-900 mb-4 leading-tight">
            نحن نحول المشاعر الصادقة إلى <span style="color: oklch(0.58 0.165 345)">لحظات إهداء مبهرة</span>
        </h1>
        <p class="text-sm sm:text-base text-gray-600 leading-relaxed">
            في "جيفتلي"، نؤمن بأن الهدية ليست مجرد منتج يُهدى، بل هي رسالة حب وتقدير وامتنان تُحفر في الذاكرة. بدأنا شغفنا لنقدم لك ولأحبائك تجربة إهداء متكاملة وفريدة من نوعها.
        </p>
    </div>

    {{-- Our Story & Vision --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center mb-16">
        <div class="card p-8 bg-gradient-to-br from-brand-50/60 to-white border-brand-200">
            <span class="text-3xl mb-3 block">✨</span>
            <h2 class="text-xl font-bold text-gray-900 mb-3">قصتنا وشغفنا</h2>
            <p class="text-xs sm:text-sm text-gray-600 leading-relaxed mb-4">
                انطلقت فكرة "جيفتلي" من رغبتنا في حل التحدي الذي يواجهه الجميع: كيف تجد هدية تجمع بين الجودة الفائقة، والجمال الآسر، واللمسة الشخصية الحقيقية دون إرهاق أو حيرة؟
            </p>
            <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">
                لذا قمنا بتصميم تشكيلات راقية من صناديق الهدايا الجاهزة والمخصصة، مع توفير خيار بناء الصندوق بنفسك خطوة بخطوة، مع طباعة رسالتك الشخصية وتوصيلها مباشرة لمن تحب.
            </p>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div class="card p-6 text-center border-brand-100">
                <span class="text-3xl font-extrabold text-brand-600 block mb-1">+5000</span>
                <span class="text-xs text-gray-500 font-medium">هدية تم تسليمها بكل حب</span>
            </div>
            <div class="card p-6 text-center border-brand-100">
                <span class="text-3xl font-extrabold text-brand-600 block mb-1">99.8%</span>
                <span class="text-xs text-gray-500 font-medium">نسبة رضا وسعادة العملاء</span>
            </div>
            <div class="card p-6 text-center border-brand-100">
                <span class="text-3xl font-extrabold text-brand-600 block mb-1">+500</span>
                <span class="text-xs text-gray-500 font-medium">منتج وهدية منتقاة بعناية</span>
            </div>
            <div class="card p-6 text-center border-brand-100">
                <span class="text-3xl font-extrabold text-brand-600 block mb-1">27</span>
                <span class="text-xs text-gray-500 font-medium">محافظة نغطيها بالشحن</span>
            </div>
        </div>
    </div>

    {{-- Core Values --}}
    <div class="mb-16">
        <h2 class="text-2xl font-extrabold text-gray-900 text-center mb-8">قيمنا التي نلتزم بها دائماً</h2>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="card p-6 text-center">
                <div class="w-12 h-12 rounded-xl bg-brand-50 text-brand-600 mx-auto flex items-center justify-center text-xl mb-4">
                    🎀
                </div>
                <h3 class="font-bold text-gray-900 text-base mb-2">الإتقان والتغليف اليدوي</h3>
                <p class="text-xs text-gray-500 leading-relaxed">
                    كل صندوق يُجهز ويُربط شريطه يدوياً بعناية فائقة واهتمام استثنائي بأدق التفاصيل والجماليات.
                </p>
            </div>

            <div class="card p-6 text-center">
                <div class="w-12 h-12 rounded-xl bg-brand-50 text-brand-600 mx-auto flex items-center justify-center text-xl mb-4">
                    💎
                </div>
                <h3 class="font-bold text-gray-900 text-base mb-2">جودة المنتجات</h3>
                <p class="text-xs text-gray-500 leading-relaxed">
                    نختار أفضل الماركات والمنتجات المعتمدة من شوكولاتة فاخرة، زهور طبيعية، وشموع عطرية ذات جودة عالية.
                </p>
            </div>

            <div class="card p-6 text-center">
                <div class="w-12 h-12 rounded-xl bg-brand-50 text-brand-600 mx-auto flex items-center justify-center text-xl mb-4">
                    🚀
                </div>
                <h3 class="font-bold text-gray-900 text-base mb-2">السرعة والمرونة</h3>
                <p class="text-xs text-gray-500 leading-relaxed">
                    طلب فوري عبر واتساب دون تعقيدات الدفع الإلكتروني، وتنسيق دقيق لوقت ومكان التسليم.
                </p>
            </div>
        </div>
    </div>

    {{-- CTA Banner --}}
    <div class="card p-8 sm:p-10 text-center bg-brand-50/50 border-brand-200">
        <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-2">هل أنت جاهز لصنع لحظة إهداء ساحرة؟</h3>
        <p class="text-xs sm:text-sm text-gray-600 mb-6 max-w-md mx-auto">
            تصفح أحدث صناديق الهدايا أو اصنع صندوقك المخصص بالكامل في دقائق معدودة.
        </p>
        <div class="flex flex-wrap justify-center gap-3">
            <a href="{{ route('custom-box-builder') }}" class="btn-primary text-sm">
                <span>✨ اصنع صندوقك الخاص</span>
            </a>
            <a href="{{ route('gift-boxes.index') }}" class="btn-secondary text-sm">
                <span>🎁 تصفح صناديق الهدايا</span>
            </a>
        </div>
    </div>

</div>
@endsection
