@extends('layouts.app')

@section('title', $giftBox->name)
@section('meta_description', Str::limit(strip_tags($giftBox->description ?? ''), 155))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-gray-400 mb-8">
        <a href="{{ route('home') }}" class="hover:text-brand-500 transition-colors">الرئيسية</a>
        <span>›</span>
        <a href="{{ route('gift-boxes.index') }}" class="hover:text-brand-500 transition-colors">صناديق الهدايا</a>
        <span>›</span>
        <span class="text-gray-600">{{ $giftBox->name }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-16" x-data="{ quantity: 1, added: false }">

        {{-- Image --}}
        <div class="relative rounded-3xl overflow-hidden shadow-xl h-96 lg:h-[480px]"
             style="background: linear-gradient(135deg, oklch(0.965 0.018 350), oklch(0.930 0.038 350))">
            @if($giftBox->image)
            <img src="{{ Storage::url($giftBox->image) }}"
                 alt="{{ $giftBox->name }}"
                 class="w-full h-full object-cover">
            @else
            <div class="w-full h-full flex items-center justify-center text-9xl">🎁</div>
            @endif
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

            {{-- Quantity & Cart --}}
            <div class="flex items-center gap-4 mb-6">
                <div class="flex items-center border-2 border-blush-200 rounded-xl overflow-hidden">
                    <button @click="quantity = Math.max(1, quantity - 1)"
                            class="px-4 py-3 text-lg font-bold hover:bg-blush-100 transition-colors">−</button>
                    <span x-text="quantity" class="px-4 py-3 text-lg font-bold min-w-12 text-center"></span>
                    <button @click="quantity++"
                            class="px-4 py-3 text-lg font-bold hover:bg-blush-100 transition-colors">+</button>
                </div>

                <button @click="$store.cart.addGiftBox({id:{{ $giftBox->id }}, name:'{{ addslashes($giftBox->name) }}', price:{{ $giftBox->price }}, image:'{{ $giftBox->image ? Storage::url($giftBox->image) : '' }}'}, quantity); added = true; setTimeout(() => added = false, 2000)"
                        class="btn-primary flex-1 justify-center py-4 text-base"
                        :class="added ? 'opacity-80' : ''">
                    <span x-text="added ? '✓ تمت الإضافة للسلة' : '🛒 أضف إلى السلة'"></span>
                </button>

                <button @click="$store.favorites.toggle({type:'gift_box', id:{{ $giftBox->id }}, name:'{{ addslashes($giftBox->name) }}', image:'{{ $giftBox->image ? Storage::url($giftBox->image) : '' }}'})"
                        class="p-4 rounded-xl border-2 border-blush-200 hover:border-brand-300 transition-colors text-xl">
                    <span x-text="$store.favorites.isFavorite('gift_box', {{ $giftBox->id }}) ? '❤️' : '🤍'"></span>
                </button>
            </div>

            <a href="{{ route('cart') }}" class="btn-secondary w-full justify-center py-3">
                🛒 إتمام الطلب عبر واتساب
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
