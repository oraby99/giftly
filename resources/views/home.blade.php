@extends('layouts.app')

@section('title', 'جيفتلي - متجر الهدايا المتميز')
@section('meta_description', 'جيفتلي متجر هدايا متميز يقدم صناديق هدايا جاهزة ومخصصة للمناسبات المختلفة. اطلب هديتك عبر واتساب.')

@section('content')

{{-- Hero Section --}}
<section class="relative overflow-hidden min-h-[90vh] flex items-center"
         style="background: linear-gradient(135deg, oklch(0.975 0.015 345) 0%, oklch(0.985 0.007 350) 50%, oklch(0.948 0.032 345) 100%)">

    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: radial-gradient(oklch(0.66 0.157 345) 1px, transparent 1px); background-size: 32px 32px;"></div>
    </div>

    {{-- Decorative circles --}}
    <div class="absolute top-20 left-10 w-64 h-64 rounded-full opacity-20 blur-3xl"
         style="background: oklch(0.74 0.13 345)"></div>
    <div class="absolute bottom-10 right-20 w-96 h-96 rounded-full opacity-15 blur-3xl"
         style="background: oklch(0.66 0.157 345)"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

            <div>
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-semibold mb-6"
                     style="background: oklch(0.66 0.157 345 / 0.12); color: oklch(0.49 0.155 345)">
                    ✨ متجر الهدايا الأول في مصر
                </div>

                <h1 class="text-5xl lg:text-6xl font-black leading-tight mb-6"
                    style="color: oklch(0.22 0.01 280)">
                    هدايا تُحكي
                    <span class="block mt-1" style="color: oklch(0.66 0.157 345)">قصة المشاعر</span>
                </h1>

                <p class="text-lg text-gray-600 leading-relaxed mb-8 max-w-lg">
                    صناديق هدايا جاهزة ومخصصة تجمع أجمل المنتجات في تغليف أنيق. 
                    أضف لمستك الشخصية واطلب عبر واتساب في دقائق.
                </p>

                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('gift-boxes.index') }}" class="btn-primary text-base py-4 px-8">
                        🎁 تسوق الصناديق الجاهزة
                    </a>
                    <a href="{{ route('custom-box-builder') }}" class="btn-secondary text-base py-4 px-8">
                        ✨ اصنع صندوقك الخاص
                    </a>
                </div>

                <div class="flex items-center gap-8 mt-10 pt-8 border-t border-blush-200">
                    <div class="text-center">
                        <div class="text-2xl font-black" style="color: oklch(0.66 0.157 345)">500+</div>
                        <div class="text-xs text-gray-500 mt-1">منتج متميز</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-black" style="color: oklch(0.66 0.157 345)">2000+</div>
                        <div class="text-xs text-gray-500 mt-1">عميل سعيد</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-black" style="color: oklch(0.66 0.157 345)">⭐ 4.9</div>
                        <div class="text-xs text-gray-500 mt-1">تقييم متميز</div>
                    </div>
                </div>
            </div>

            <div class="relative">
                <div class="relative rounded-3xl overflow-hidden shadow-2xl"
                     style="box-shadow: 0 32px 64px -12px oklch(0.66 0.157 345 / 0.3)">
                    <img src="/images/hero-banner.jpg"
                         alt="صناديق هدايا جيفتلي"
                         class="w-full h-96 lg:h-[480px] object-cover"
                         loading="eager">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                </div>

                {{-- Floating badges --}}
                <div class="absolute -top-4 -right-4 bg-white rounded-2xl p-3 shadow-xl border border-blush-100 animate-bounce">
                    <div class="text-2xl">🎀</div>
                    <div class="text-xs font-bold text-gray-700 mt-1">تغليف فاخر</div>
                </div>
                <div class="absolute -bottom-4 -left-4 bg-white rounded-2xl p-3 shadow-xl border border-blush-100">
                    <div class="text-2xl">💬</div>
                    <div class="text-xs font-bold text-gray-700 mt-1">طلب واتساب</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Benefits Bar --}}
<section class="bg-white border-y border-blush-200 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach([
                ['🚀', 'توصيل سريع', 'لجميع أنحاء مصر'],
                ['🎀', 'تغليف مميز', 'بأيدي متخصصين'],
                ['✨', 'منتجات أصلية', '100% جودة مضمونة'],
                ['💬', 'دعم واتساب', 'متاح طوال اليوم'],
            ] as [$icon, $title, $desc])
            <div class="flex items-center gap-3">
                <div class="text-3xl shrink-0">{{ $icon }}</div>
                <div>
                    <div class="font-bold text-sm text-gray-800">{{ $title }}</div>
                    <div class="text-xs text-gray-500">{{ $desc }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Occasions Section --}}
@if($occasions->isNotEmpty())
<section class="py-16 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <h2 class="section-title">تسوق حسب المناسبة</h2>
    <p class="section-subtitle">هدية مثالية لكل لحظة خاصة</p>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
        @foreach($occasions as $occasion)
        <a href="{{ route('gift-boxes.index', ['occasion' => $occasion->slug]) }}"
           class="group flex flex-col items-center gap-3 p-4 rounded-2xl border-2 border-transparent hover:border-brand-200 transition-all duration-200 hover:shadow-md hover:-translate-y-1 bg-white text-center">
            @if($occasion->image)
            <img src="{{ Storage::url($occasion->image) }}"
                 alt="{{ $occasion->name }}"
                 class="w-16 h-16 rounded-full object-cover shadow-md group-hover:scale-110 transition-transform"
                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
            <div class="w-16 h-16 rounded-full items-center justify-center text-3xl shadow-md hidden"
                 style="background: linear-gradient(135deg, oklch(0.948 0.032 345), oklch(0.893 0.062 345))">
                🌸
            </div>
            @else
            <div class="w-16 h-16 rounded-full flex items-center justify-center text-3xl shadow-md"
                 style="background: linear-gradient(135deg, oklch(0.948 0.032 345), oklch(0.893 0.062 345))">
                🌸
            </div>
            @endif
            <span class="text-sm font-semibold text-gray-700 group-hover:text-brand-600 transition-colors">
                {{ $occasion->name }}
            </span>
        </a>
        @endforeach
    </div>
</section>
@endif

{{-- Featured Gift Boxes --}}
@if($featuredGiftBoxes->isNotEmpty())
<section class="py-16 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-3xl font-black" style="color: oklch(0.22 0.01 280)">صناديق هدايا مميزة</h2>
            <p class="text-gray-500 mt-1">اختيارات خاصة بعناية</p>
        </div>
        <a href="{{ route('gift-boxes.index') }}" class="btn-secondary py-2.5 px-5 text-sm">
            عرض الكل ←
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($featuredGiftBoxes as $box)
        <div class="product-card group" x-data="{ added: false }">
            <div class="relative overflow-hidden">
                @if($box->image)
                <img src="{{ Storage::url($box->image) }}"
                     alt="{{ $box->name }}"
                     class="w-full h-56 object-cover group-hover:scale-105 transition-transform duration-300"
                     loading="lazy"
                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                <div class="w-full h-56 items-center justify-center text-6xl hidden"
                     style="background: linear-gradient(135deg, oklch(0.965 0.018 350), oklch(0.930 0.038 350))">
                    🎁
                </div>
                @else
                <div class="w-full h-56 flex items-center justify-center text-6xl"
                     style="background: linear-gradient(135deg, oklch(0.965 0.018 350), oklch(0.930 0.038 350))">
                    🎁
                </div>
                @endif

                <button @click="$store.favorites.toggle({type:'gift_box', id:{{ $box->id }}, name:'{{ $box->name }}', image:'{{ $box->image ? Storage::url($box->image) : '' }}'})"
                        class="absolute top-3 left-3 w-9 h-9 bg-white/90 backdrop-blur rounded-full flex items-center justify-center shadow-md hover:scale-110 transition-transform">
                    <span x-text="$store.favorites.isFavorite('gift_box', {{ $box->id }}) ? '❤️' : '🤍'"></span>
                </button>
            </div>

            <div class="product-card-body">
                <h3 class="font-bold text-gray-800 mb-1 line-clamp-2">{{ $box->name }}</h3>
                <div class="flex flex-wrap gap-1 mb-3">
                    @foreach($box->occasions->take(2) as $occasion)
                    <span class="text-xs px-2 py-0.5 rounded-full font-medium"
                          style="background: oklch(0.948 0.032 345); color: oklch(0.49 0.155 345)">
                        {{ $occasion->name }}
                    </span>
                    @endforeach
                </div>
                <div class="mt-auto flex items-center justify-between">
                    <span class="badge-price">{{ number_format($box->price, 0) }} ج.م</span>
                    <div class="flex gap-2">
                        <a href="{{ route('gift-boxes.show', $box->slug) }}"
                           class="text-xs text-gray-500 hover:text-brand-600 transition-colors py-1">تفاصيل</a>
                        <button @click="$store.cart.addGiftBox({id:{{ $box->id }}, name:'{{ addslashes($box->name) }}', price:{{ $box->price }}, image:'{{ $box->image ? Storage::url($box->image) : '' }}'}); added = true; setTimeout(() => added = false, 2000)"
                                class="btn-primary py-1.5 px-3 text-xs"
                                :class="added ? 'opacity-75' : ''">
                            <span x-text="added ? '✓ أُضيف' : '+ سلة'"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endif

{{-- Custom Box Builder CTA --}}
<section class="py-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto rounded-3xl overflow-hidden relative"
         style="background: linear-gradient(135deg, oklch(0.49 0.155 345), oklch(0.66 0.157 345))">
        <div class="absolute inset-0 opacity-10"
             style="background-image: radial-gradient(white 1px, transparent 1px); background-size: 20px 20px;"></div>
        <div class="relative p-12 text-center text-white">
            <div class="text-5xl mb-4">✨</div>
            <h2 class="text-3xl font-black mb-4">اصنع صندوق هديتك المثالي</h2>
            <p class="text-lg opacity-90 mb-8 max-w-xl mx-auto">
                اختر المنتجات التي تحبها، أضف رسالة شخصية، وحدد التغليف المناسب. هديتك، أسلوبك.
            </p>
            <div class="flex flex-wrap gap-4 justify-center">
                <a href="{{ route('custom-box-builder') }}"
                   class="bg-white font-bold py-4 px-8 rounded-xl transition-all hover:shadow-xl hover:-translate-y-0.5 text-base"
                   style="color: oklch(0.49 0.155 345)">
                    ابدأ تصميم صندوقك 🎨
                </a>
            </div>
            <div class="mt-8 flex justify-center gap-8 text-sm opacity-80">
                <span>✓ أكثر من 100 منتج</span>
                <span>✓ تغليف فاخر</span>
                <span>✓ رسالة شخصية</span>
            </div>
        </div>
    </div>
</section>

{{-- Featured Products --}}
@if($featuredProducts->isNotEmpty())
<section class="py-16 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-3xl font-black" style="color: oklch(0.22 0.01 280)">أفضل المنتجات</h2>
            <p class="text-gray-500 mt-1">الأكثر طلباً لدى عملائنا</p>
        </div>
        <a href="{{ route('products.index') }}" class="btn-secondary py-2.5 px-5 text-sm">
            عرض الكل ←
        </a>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-5">
        @foreach($featuredProducts as $product)
        <div class="product-card group" x-data="{ added: false }">
            <div class="relative overflow-hidden">
                @if($product->image)
                <img src="{{ Storage::url($product->image) }}"
                     alt="{{ $product->name }}"
                     class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300"
                     loading="lazy"
                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                <div class="w-full h-48 items-center justify-center text-5xl hidden"
                     style="background: linear-gradient(135deg, oklch(0.965 0.018 350), oklch(0.930 0.038 350))">
                    🎀
                </div>
                @else
                <div class="w-full h-48 flex items-center justify-center text-5xl"
                     style="background: linear-gradient(135deg, oklch(0.965 0.018 350), oklch(0.930 0.038 350))">
                    🎀
                </div>
                @endif
                <button @click="$store.favorites.toggle({type:'product', id:{{ $product->id }}, name:'{{ $product->name }}', image:'{{ $product->image ? Storage::url($product->image) : '' }}'})"
                        class="absolute top-3 left-3 w-8 h-8 bg-white/90 backdrop-blur rounded-full flex items-center justify-center shadow-md hover:scale-110 transition-transform text-sm">
                    <span x-text="$store.favorites.isFavorite('product', {{ $product->id }}) ? '❤️' : '🤍'"></span>
                </button>
            </div>
            <div class="product-card-body">
                <h3 class="font-semibold text-gray-800 text-sm mb-2 line-clamp-2">{{ $product->name }}</h3>
                <div class="mt-auto flex items-center justify-between">
                    <span class="badge-price text-sm">{{ number_format($product->price, 0) }} ج.م</span>
                    <a href="{{ route('products.show', $product->slug) }}"
                       class="text-xs text-gray-400 hover:text-brand-600 transition-colors">
                        تفاصيل →
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endif

{{-- Corporate Gifts Section --}}
<section class="py-16 px-4 sm:px-6 lg:px-8 bg-white">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-sm font-semibold mb-4"
                     style="background: oklch(0.66 0.157 345 / 0.1); color: oklch(0.49 0.155 345)">
                    🏢 هدايا الشركات
                </div>
                <h2 class="text-4xl font-black mb-4" style="color: oklch(0.22 0.01 280)">
                    حلول هدايا مؤسسية
                    <span class="block" style="color: oklch(0.66 0.157 345)">لفريق عملك</span>
                </h2>
                <p class="text-gray-600 leading-relaxed mb-6">
                    خصصنا لشركتك برنامج هدايا مميز للموظفين والعملاء والمناسبات الرسمية. 
                    أسعار خاصة للكميات الكبيرة مع إمكانية التخصيص الكامل.
                </p>
                <ul class="space-y-3 mb-8">
                    @foreach(['أسعار خاصة للكميات الكبيرة', 'تخصيص كامل بشعار شركتك', 'توصيل منظم ومتزامن', 'متابعة ودعم مستمر'] as $benefit)
                    <li class="flex items-center gap-3 text-gray-700">
                        <span class="w-5 h-5 rounded-full flex items-center justify-center text-xs font-bold text-white flex-shrink-0"
                              style="background: oklch(0.66 0.157 345)">✓</span>
                        {{ $benefit }}
                    </li>
                    @endforeach
                </ul>
                <a href="{{ route('corporate.index') }}" class="btn-primary">
                    طلب عرض سعر 📋
                </a>
            </div>
            <div class="relative rounded-3xl overflow-hidden h-80 lg:h-96 bg-gradient-to-br"
                 style="background: linear-gradient(135deg, oklch(0.965 0.018 350), oklch(0.930 0.038 350))">
                <div class="absolute inset-0 flex items-center justify-center text-9xl opacity-50">🏢</div>
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="text-center text-white">
                        <div class="text-6xl mb-4">🎁</div>
                        <div class="font-black text-2xl" style="color: oklch(0.49 0.155 345)">هدايا الشركات</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Testimonials --}}
<section class="py-16 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto" x-data="{ openReviewModal: false }">
    <div class="flex flex-col sm:flex-row items-center justify-between mb-8 gap-4">
        <div class="text-center sm:text-right">
            <h2 class="text-2xl sm:text-3xl font-black text-gray-900">ماذا يقول عملاؤنا</h2>
            <p class="text-sm text-gray-500 mt-1">آراء حقيقية من عملاء سعداء بتجربة جيفتلي</p>
        </div>
        <button type="button"
                @click="openReviewModal = !openReviewModal"
                class="btn-primary py-2.5 px-5 text-xs sm:text-sm shadow-sm flex items-center gap-2">
            <span>✍️</span>
            <span>شاركنا تجربتك وقيّم المتجر</span>
        </button>
    </div>

    {{-- Review Form Accordion / Modal Box --}}
    <div x-cloak x-show="openReviewModal" x-collapse class="card p-6 mb-8 border-brand-200 bg-brand-50/20 max-w-2xl mx-auto">
        <div class="flex items-center justify-between mb-4 border-b border-brand-100 pb-3">
            <h3 class="font-bold text-base text-gray-900">شاركنا رأيك في تجربة الإهداء مع جيفتلي</h3>
            <button type="button" @click="openReviewModal = false" class="text-gray-400 hover:text-gray-600 text-sm">✕ إغلاق</button>
        </div>

        <form action="{{ route('reviews.store') }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">اسمك الكريم *</label>
                    <input type="text" name="customer_name" required placeholder="مثال: مريم حسن" class="input-field text-xs">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">التقييم *</label>
                    <select name="rating" class="input-field text-xs">
                        <option value="5">⭐⭐⭐⭐⭐ ممتاز (5 من 5)</option>
                        <option value="4">⭐⭐⭐⭐ جيد جداً (4 من 5)</option>
                        <option value="3">⭐⭐⭐ جيد (3 من 5)</option>
                        <option value="2">⭐⭐ مقبول (2 من 5)</option>
                        <option value="1">⭐ ضعيف (1 من 5)</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">رأيك وتجربتك معنا *</label>
                <textarea name="comment" rows="3" required placeholder="اكتب كيف كانت تجربتك مع التغليف، التوصيل، وجودة المنتجات..." class="input-field text-xs"></textarea>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="btn-primary text-xs py-2.5 px-6 shadow-sm">
                    إرسال التقييم 📤
                </button>
            </div>
        </form>
    </div>

    {{-- Testimonials Cards Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @if(isset($reviews) && $reviews->isNotEmpty())
            @foreach($reviews as $rev)
            <div class="card p-6 flex flex-col justify-between">
                <div>
                    <div class="flex items-center gap-1 mb-3">
                        @for($i = 0; $i < $rev->rating; $i++)
                            <span class="text-yellow-400 text-base">⭐</span>
                        @endfor
                    </div>
                    <p class="text-gray-600 text-sm leading-relaxed mb-4">"{{ $rev->comment }}"</p>
                </div>
                <div class="flex items-center gap-3 pt-3 border-t border-gray-50">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-white text-sm"
                         style="background: linear-gradient(135deg, oklch(0.66 0.157 345), oklch(0.49 0.155 345))">
                        {{ mb_substr($rev->customer_name ?? 'ع', 0, 1) }}
                    </div>
                    <div>
                        <div class="font-bold text-sm text-gray-800">{{ $rev->customer_name }}</div>
                        <div class="text-[11px] text-brand-600">عميل موثوق ✓</div>
                    </div>
                </div>
            </div>
            @endforeach
        @else
            @foreach([
                ['سارة أحمد', 'القاهرة', 5, 'أفضل صندوق هدايا اشتريته في حياتي! التغليف فاخر جداً والمنتجات ممتازة. أصبحت عميلة دائمة.'],
                ['محمد علي', 'الإسكندرية', 5, 'طلبت صندوق مخصص لزوجتي في عيد ميلادها وكان أجمل مما تخيلت. شكراً جيفتلي!'],
                ['نورهان كريم', 'الجيزة', 5, 'خدمة ممتازة والتوصيل كان في الوقت المحدد. هدية أمي في عيد الأم كانت رائعة!'],
            ] as [$name, $city, $rating, $text])
            <div class="card p-6 flex flex-col justify-between">
                <div>
                    <div class="flex items-center gap-1 mb-3">
                        @for($i = 0; $i < $rating; $i++)
                        <span class="text-yellow-400 text-base">⭐</span>
                        @endfor
                    </div>
                    <p class="text-gray-600 text-sm leading-relaxed mb-4">"{{ $text }}"</p>
                </div>
                <div class="flex items-center gap-3 pt-3 border-t border-gray-50">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-white text-sm"
                         style="background: linear-gradient(135deg, oklch(0.66 0.157 345), oklch(0.49 0.155 345))">
                        {{ mb_substr($name, 0, 1) }}
                    </div>
                    <div>
                        <div class="font-bold text-sm text-gray-800">{{ $name }}</div>
                        <div class="text-xs text-gray-400">{{ $city }}</div>
                    </div>
                </div>
            </div>
            @endforeach
        @endif
    </div>
</section>

@endsection
