@extends('layouts.app')

@section('title', $giftBox->name)
@section('meta_description', Str::limit(strip_tags($giftBox->description ?? ''), 155))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10" x-data="{ showBoxPopup: {{ request('open') ? 'true' : 'false' }}, showContents: true, quantity: 1, added: false }">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-gray-400 mb-8">
        <a href="{{ route('home') }}" class="hover:text-brand-500 transition-colors">الرئيسية</a>
        <span>›</span>
        <a href="{{ route('gift-boxes.index') }}" class="hover:text-brand-500 transition-colors">صناديق الهدايا</a>
        <span>›</span>
        <span class="text-gray-600">{{ $giftBox->name }}</span>
    </nav>

    {{-- Big Custom Gift Box Popup Modal --}}
    <div x-show="showBoxPopup"
         x-cloak
         @keydown.escape.window="showBoxPopup = false"
         class="fixed inset-0 z-50 overflow-y-auto"
         aria-labelledby="modal-title"
         role="dialog"
         aria-modal="true">
        
        {{-- Backdrop --}}
        <div x-show="showBoxPopup"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="showBoxPopup = false"
             class="fixed inset-0 bg-stone-900/70 backdrop-blur-sm transition-opacity"></div>

        {{-- Modal Dialog --}}
        <div class="flex min-h-full items-center justify-center p-3 sm:p-6 lg:p-8">
            <div x-show="showBoxPopup"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 @click.stop
                 class="relative transform overflow-hidden rounded-3xl bg-white text-right shadow-2xl transition-all w-full max-w-4xl border border-pink-100">

                <div class="grid grid-cols-1 md:grid-cols-12 max-h-[88vh] overflow-y-auto">
                    {{-- Image Column --}}
                    <div class="md:col-span-5 bg-gradient-to-br from-pink-50 via-rose-50 to-pink-100 p-6 flex flex-col justify-between items-center relative min-h-[300px] md:min-h-[480px]">
                        <div class="w-full pr-12">
                            <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-bold text-pink-700 bg-white/80 shadow-sm border border-pink-200">
                                🎁 بوكس هدايا مخصص
                            </span>
                        </div>

                        <div class="w-full my-auto py-4">
                            @if($giftBox->image)
                            <img src="{{ Storage::url($giftBox->image) }}"
                                 alt="{{ $giftBox->name }}"
                                 class="w-full max-h-72 md:max-h-80 object-cover rounded-2xl shadow-xl ring-4 ring-white/60 mx-auto">
                            @else
                            <div class="w-48 h-48 rounded-2xl bg-white/80 flex items-center justify-center text-7xl shadow-lg mx-auto">
                                🎁
                            </div>
                            @endif
                        </div>

                        <div class="w-full bg-white/90 backdrop-blur-sm rounded-2xl p-4 text-center border border-pink-100 shadow-sm">
                            <div class="text-xs text-gray-500 font-medium mb-1">سعر البوكس المخصص</div>
                            <div class="text-2xl font-black text-pink-600 font-mono">
                                {{ number_format($giftBox->price, 2) }} ج.م
                            </div>
                        </div>
                    </div>

                    {{-- Content Column --}}
                    <div class="md:col-span-7 p-6 sm:p-8 flex flex-col justify-between space-y-5">
                        <div>
                            {{-- Header Title & Subtitle --}}
                            <div class="mb-4">
                                <h2 class="text-2xl sm:text-3xl font-black text-gray-900 mb-2 flex items-center gap-2">
                                    <span>{{ $giftBox->name }}</span>
                                </h2>
                                <p class="text-base sm:text-lg font-bold text-pink-600 leading-snug">
                                    مش كل الكلام بيتقال... بعض الكلام بيتحط في بوكس.
                                </p>
                                <p class="text-sm text-gray-600 mt-1 leading-relaxed">
                                    صوركم، رسائلكم، وذكرياتكم في هدية واحدة مخصصة ليها.
                                </p>
                            </div>

                            {{-- Conversational Card --}}
                            <div class="bg-gradient-to-r from-pink-50/80 to-rose-50/50 rounded-2xl p-4 border border-pink-200/60 mb-4">
                                <div class="flex items-start gap-3">
                                    <div class="text-2xl">💌</div>
                                    <div class="text-sm text-gray-800 leading-relaxed font-medium">
                                        <p class="font-bold text-pink-700 mb-1">أهلاً بيك ❤️</p>
                                        <p>بوكس «{{ $boxDisplayName }}» بيتعمل مخصوص للشخص اللي هتهديهوله، وبيضم صوركم ورسائلكم بطريقة شخصية جدًا.</p>
                                        <div class="mt-2.5 flex items-center justify-between">
                                            <span x-show="!showContents" class="text-xs text-gray-500 font-bold">تحب تشوف محتويات البوكس والأسعار؟ 🎁</span>
                                            <button type="button"
                                                    @click="showContents = !showContents"
                                                    class="text-xs bg-white text-pink-600 border border-pink-300 font-bold px-3 py-1.5 rounded-lg shadow-sm hover:bg-pink-600 hover:text-white transition-all flex items-center gap-1"
                                                    :class="showContents ? 'mr-auto' : ''">
                                                <span x-text="showContents ? 'إخفاء' : 'أيوه، اعرضلي'"></span>
                                                <span x-text="showContents ? '▲' : '▼'"></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Collapsible Contents List --}}
                            <div x-show="showContents"
                                 x-collapse
                                 class="space-y-4 mb-4">
                                <div class="bg-gray-50/80 rounded-2xl p-4 border border-gray-200/80">
                                    <h4 class="font-bold text-sm text-gray-900 mb-3 flex items-center gap-2">
                                        <span>✨ محتويات البوكس:</span>
                                    </h4>
                                    <ul class="space-y-2 text-sm text-gray-700">
                                        @if($giftBox->items->isNotEmpty())
                                            @foreach($giftBox->items as $index => $item)
                                            <li class="flex items-center gap-2.5">
                                                <span class="w-5 h-5 rounded-full bg-pink-100 text-pink-600 flex items-center justify-center text-xs font-bold shrink-0">
                                                    {{ $index + 1 }}
                                                </span>
                                                <span class="font-medium text-gray-800">{{ $item->product?->name }}</span>
                                            </li>
                                            @endforeach
                                        @else
                                            <li class="flex items-center gap-2.5">
                                                <span class="w-5 h-5 rounded-full bg-pink-100 text-pink-600 flex items-center justify-center text-xs font-bold shrink-0">1</span>
                                                <span class="font-medium text-gray-800">رسالة من قلبي ليك</span>
                                            </li>
                                            <li class="flex items-center gap-2.5">
                                                <span class="w-5 h-5 rounded-full bg-pink-100 text-pink-600 flex items-center justify-center text-xs font-bold shrink-0">2</span>
                                                <span class="font-medium text-gray-800">برطمان مواقف ورسائل صغيرة بتقول كتير</span>
                                            </li>
                                            <li class="flex items-center gap-2.5">
                                                <span class="w-5 h-5 rounded-full bg-pink-100 text-pink-600 flex items-center justify-center text-xs font-bold shrink-0">3</span>
                                                <span class="font-medium text-gray-800">برواز ذكرياتنا الحلوة لطباعة الصور</span>
                                            </li>
                                        @endif
                                    </ul>
                                </div>

                                {{-- What we need to prepare the box --}}
                                <div class="bg-amber-50/60 rounded-2xl p-4 border border-amber-200/60 text-sm space-y-2.5">
                                    <div class="font-bold text-amber-900 text-xs sm:text-sm">
                                        + عشان نبدأ نجهز بوكس «{{ $boxDisplayName }}» بتفاصيله الخاصة بيكم، محتاجين منك:
                                    </div>
                                    <div class="space-y-1.5 text-xs sm:text-sm text-gray-700">
                                        <div class="flex items-start gap-2">
                                            <span class="shrink-0 text-base">📸</span>
                                            <span><strong>الصور:</strong> من 5 إلى 10 صور تحب تضيفها للبوكس.</span>
                                        </div>
                                        <div class="flex items-start gap-2">
                                            <span class="shrink-0 text-base">💌</span>
                                            <span><strong>الرسائل:</strong> ابعتلنا الرسائل اللي حابب نحطها، سواء رسالة واحدة طويلة أو أكتر من رسالة قصيرة وممكن نساعدك لو حتى الكلام اللي هتقوله مش مرتب ♥️</span>
                                        </div>
                                        <div class="flex items-start gap-2">
                                            <span class="shrink-0 text-base">🎁</span>
                                            <span><strong>طلبات خاصة:</strong> ولو عندك أي طلب خاص في التصميم أو ترتيب الصور والرسائل، اكتبهولنا.</span>
                                        </div>
                                    </div>
                                    <p class="text-xs text-rose-800 font-medium pt-1">
                                        ممكن تبعت الصور والرسائل هنا على الواتساب مباشرة، وإحنا هنرتبهم ونجهز التصميم ليك ❤️
                                    </p>
                                    <div class="pt-2 border-t border-amber-200/40 text-xs text-amber-800 font-semibold flex items-center gap-1.5">
                                        <span>💡 ملحوظة:</span>
                                        <span>يفضل إرسال الصور بجودتها الأصلية عشان نطلعها بأفضل جودة ممكنة.</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="pt-3 border-t border-gray-100 space-y-2.5">
                            <button type="button"
                                    @click="$store.cart.addGiftBox({id:{{ $giftBox->id }}, name:'{{ addslashes($giftBox->name) }}', price:{{ $giftBox->price }}, image:'{{ $giftBox->image ? Storage::url($giftBox->image) : '' }}'}, quantity); window.location.href = '{{ route('cart') }}'"
                                    class="w-full btn-primary font-bold py-3.5 px-6 rounded-2xl flex items-center justify-center gap-2.5 shadow-lg hover:shadow-xl transition-all duration-200 text-base sm:text-lg group">
                                <span>أضف هذا البوكس إلى السلة</span>
                                <span class="text-xl">🛒</span>
                            </button>

                            <div class="flex items-center justify-between text-xs text-gray-500 pt-1">
                                <span class="flex items-center gap-1 text-emerald-600 font-medium">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                    ترسل الصور والرسائل عبر واتساب بعد إتمام الطلب مباشرة
                                </span>
                                <button type="button" @click="showBoxPopup = false" class="text-pink-600 hover:underline font-bold">
                                    إغلاق النافذة ✕
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Prominent Close Button (Top-Right) --}}
                <button type="button"
                        @click.stop="showBoxPopup = false"
                        style="position: absolute; top: 14px; right: 14px; z-index: 99999 !important; width: 40px; height: 40px; border-radius: 9999px; background: #ffffff; box-shadow: 0 4px 14px rgba(0, 0, 0, 0.2); border: 1px solid rgba(0, 0, 0, 0.12); display: flex; align-items: center; justify-content: center; cursor: pointer !important; pointer-events: auto !important;"
                        class="hover:bg-pink-50 hover:scale-105 active:scale-95 transition-all text-gray-700 hover:text-gray-900"
                        title="إغلاق النافذة"
                        aria-label="إغلاق النافذة">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#1f2937" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width: 20px; height: 20px; pointer-events: none;">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Main Page Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-16">

        {{-- Image & Discover Action --}}
        <div>
            <div @click="showBoxPopup = true"
                 class="relative rounded-3xl overflow-hidden shadow-xl h-96 lg:h-[480px] cursor-pointer group hover:shadow-2xl transition-all duration-300 transform hover:scale-[1.01]"
                 style="background: linear-gradient(135deg, oklch(0.965 0.018 350), oklch(0.930 0.038 350))"
                 title="انقر لاكتشاف ما بداخل البوكس">
                @if($giftBox->image)
                <img src="{{ Storage::url($giftBox->image) }}"
                     alt="{{ $giftBox->name }}"
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                @else
                <div class="w-full h-full flex items-center justify-center text-9xl">🎁</div>
                @endif

                {{-- Hint Overlay on Image Hover --}}
                <div class="absolute inset-0 bg-stone-900/15 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                    <span class="bg-white/95 text-pink-600 font-bold px-4 py-2.5 rounded-2xl text-sm shadow-xl flex items-center gap-2">
                        <span>🔍</span> انقر لرؤية محتويات البوكس
                    </span>
                </div>
            </div>

            {{-- Button directly under the image: "اكتشف اللي جواه ↓" --}}
            <button type="button"
                    @click="showBoxPopup = true"
                    class="w-full mt-4 py-3.5 px-6 rounded-2xl bg-gradient-to-r from-pink-500 via-rose-500 to-pink-600 hover:from-pink-600 hover:to-rose-600 text-white font-extrabold text-base sm:text-lg shadow-lg hover:shadow-xl transition-all flex items-center justify-center gap-2.5 group cursor-pointer">
                <span>اكتشف اللي جواه ↓</span>
                <span class="text-xl group-hover:translate-y-1 transition-transform">🎁</span>
            </button>
        </div>

        {{-- Details --}}
        <div>
            @if($giftBox->is_featured)
            <span class="inline-flex items-center gap-1 text-xs font-bold px-3 py-1 rounded-full mb-3"
                  style="background: oklch(0.948 0.032 345); color: oklch(0.49 0.155 345)">
                ⭐ صندوق مميز
            </span>
            @endif

            <h1 class="text-4xl font-black mb-3" style="color: oklch(0.22 0.01 280)">{{ $giftBox->name }}</h1>

            <div class="flex items-center gap-4 mb-6">
                <span class="text-3xl font-black" style="color: oklch(0.66 0.157 345)">
                    {{ number_format($giftBox->price, 2) }} ج.م
                </span>
            </div>

            @if($giftBox->occasions->isNotEmpty())
            <div class="flex flex-wrap gap-2 mb-6">
                @foreach($giftBox->occasions as $occasion)
                <a href="{{ route('gift-boxes.index', ['occasion' => $occasion->slug]) }}"
                   class="text-sm px-3 py-1.5 rounded-full font-medium border transition-colors hover:text-brand-600"
                   style="background: oklch(0.948 0.032 345); border-color: oklch(0.893 0.062 345); color: oklch(0.58 0.165 345)">
                    {{ $occasion->name }}
                </a>
                @endforeach
            </div>
            @endif

            @if($giftBox->description)
            <div class="text-gray-600 leading-relaxed mb-6">{{ $giftBox->description }}</div>
            @endif

            {{-- Open Popup CTA Button Banner --}}
            <div @click="showBoxPopup = true" class="mb-6 p-4 sm:p-5 rounded-[24px] border border-gray-900 bg-white flex items-center justify-between gap-4 cursor-pointer hover:shadow-md transition-all group">
                <div class="text-right">
                    <div class="font-black text-base sm:text-lg text-gray-900 leading-tight">محتويات البوكس وتعليمات التجهيز</div>
                    <div class="text-xs sm:text-sm text-gray-500 mt-1">شاهد قائمة الهدايا وما سنطلبه منك لتجهيز الهدية</div>
                </div>
                <button type="button"
                        class="px-5 sm:px-6 py-2.5 rounded-full text-white font-extrabold text-xs sm:text-sm shadow-md shrink-0 pointer-events-none group-hover:scale-105 transition-transform"
                        style="background: linear-gradient(135deg, #a42c67 0%, #b83677 100%);">
                    اكتشف اللي جواه ↓
                </button>
            </div>

            {{-- Quantity & Cart --}}
            <div class="flex items-center gap-4 mb-4">
                <div class="flex items-center border-2 border-blush-200 rounded-xl overflow-hidden">
                    <button @click="quantity = Math.max(1, quantity - 1)"
                            class="px-4 py-3 text-lg font-bold hover:bg-blush-100 transition-colors">−</button>
                    <span x-text="quantity" class="px-4 py-3 text-lg font-bold min-w-12 text-center"></span>
                    <button @click="quantity++"
                            class="px-4 py-3 text-lg font-bold hover:bg-blush-100 transition-colors">+</button>
                </div>

                <button @click="$store.cart.addGiftBox({id:{{ $giftBox->id }}, name:'{{ addslashes($giftBox->name) }}', price:{{ $giftBox->price }}, image:'{{ $giftBox->image ? Storage::url($giftBox->image) : '' }}'}, quantity); window.location.href = '{{ route('cart') }}'"
                        class="btn-primary flex-1 justify-center py-4 text-base">
                    <span>🛒 أضف إلى السلة</span>
                </button>

                <button @click="$store.favorites.toggle({type:'gift_box', id:{{ $giftBox->id }}, name:'{{ addslashes($giftBox->name) }}', image:'{{ $giftBox->image ? Storage::url($giftBox->image) : '' }}'})"
                        class="p-4 rounded-xl border-2 border-blush-200 hover:border-brand-300 transition-colors text-xl">
                    <span x-text="$store.favorites.isFavorite('gift_box', {{ $giftBox->id }}) ? '❤️' : '🤍'"></span>
                </button>
            </div>

            <a href="{{ route('cart') }}" class="btn-secondary w-full justify-center py-3 text-sm">
                الانتقال إلى سلة المشتريات ←
            </a>
        </div>
    </div>

    {{-- Box Contents --}}
    @if($giftBox->items->isNotEmpty())
    <div class="card p-8 mb-12">
        <h2 class="text-2xl font-black mb-6" style="color: oklch(0.22 0.01 280)">محتويات الصندوق</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($giftBox->items as $item)
            <div class="flex items-center gap-3 p-3 rounded-xl border border-blush-200 bg-blush-50">
                @if($item->product?->image)
                <img src="{{ Storage::url($item->product->image) }}"
                     alt="{{ $item->product->name }}"
                     class="w-12 h-12 rounded-lg object-cover">
                @else
                <div class="w-12 h-12 rounded-lg flex items-center justify-center text-2xl bg-blush-100">🎁</div>
                @endif
                <div>
                    <div class="font-semibold text-sm text-gray-800 line-clamp-1">{{ $item->product?->name }}</div>
                    <div class="text-xs text-gray-400">الكمية: {{ $item->quantity }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Reviews Section --}}
    <div class="mb-12" x-data="{ showReviewModal: false }">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-black" style="color: oklch(0.22 0.01 280)">تقييمات العملاء</h2>
            <button type="button" @click="showReviewModal = !showReviewModal" class="btn-secondary text-xs py-2 px-4">
                ✍️ أضف تقييمك
            </button>
        </div>

        {{-- Review Form Accordion --}}
        <div x-show="showReviewModal" x-collapse class="card p-6 mb-6 border-brand-200 bg-brand-50/20">
            <h3 class="font-bold text-sm text-gray-900 mb-3">شاركنا رأيك في هذا الصندوق</h3>
            <form action="{{ route('reviews.store') }}" method="POST" class="space-y-3">
                @csrf
                <input type="hidden" name="gift_box_id" value="{{ $giftBox->id }}">

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">اسمك الكريم *</label>
                        <input type="text" name="customer_name" required placeholder="مثال: منى علي" class="input-field text-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">التقييم *</label>
                        <select name="rating" class="input-field text-xs">
                            <option value="5">⭐⭐⭐⭐⭐ ممتاز (5/5)</option>
                            <option value="4">⭐⭐⭐⭐ جيد جداً (4/5)</option>
                            <option value="3">⭐⭐⭐ جيد (3/5)</option>
                            <option value="2">⭐⭐ مقبول (2/5)</option>
                            <option value="1">⭐ ضعيف (1/5)</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">تعليقك (اختياري)</label>
                    <textarea name="comment" rows="2" placeholder="اكتب رأيك الصادق في التغليف والمنتجات..." class="input-field text-xs"></textarea>
                </div>

                <button type="submit" class="btn-primary text-xs py-2 px-5">إرسال التقييم</button>
            </form>
        </div>

        @if($giftBox->reviews->isNotEmpty())
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($giftBox->reviews as $review)
            <div class="card p-5">
                <div class="flex items-center gap-1 mb-2">
                    @for($i = 0; $i < $review->rating; $i++)<span class="text-yellow-400">⭐</span>@endfor
                </div>
                @if($review->comment)
                <p class="text-gray-600 text-sm leading-relaxed mb-3">"{{ $review->comment }}"</p>
                @endif
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-bold"
                         style="background: oklch(0.66 0.157 345)">
                        {{ mb_substr($review->customer_name ?? 'م', 0, 1) }}
                    </div>
                    <span class="text-sm font-semibold text-gray-700">{{ $review->customer_name ?? 'عميل' }}</span>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-xs text-gray-400 italic">لا توجد تقييمات منشورة بعد، كن أول من يشاركنا رأيه!</p>
        @endif
    </div>

    {{-- Related --}}
    @if($related->isNotEmpty())
    <div>
        <h2 class="text-2xl font-black mb-6" style="color: oklch(0.22 0.01 280)">صناديق مشابهة</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
            @foreach($related as $box)
            <a href="{{ route('gift-boxes.show', $box->slug) }}" class="product-card group">
                @if($box->image)
                <img src="{{ Storage::url($box->image) }}"
                     alt="{{ $box->name }}"
                     class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300"
                     loading="lazy">
                @else
                <div class="w-full h-48 flex items-center justify-center text-5xl bg-blush-100">🎁</div>
                @endif
                <div class="p-4">
                    <h3 class="font-bold text-sm text-gray-800 line-clamp-1">{{ $box->name }}</h3>
                    <span class="text-sm font-bold" style="color: oklch(0.66 0.157 345)">
                        {{ number_format($box->price, 0) }} ج.م
                    </span>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif

</div>
@endsection
