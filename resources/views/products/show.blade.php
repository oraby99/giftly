@extends('layouts.app')

@section('title', $product->name)
@section('meta_description', Str::limit(strip_tags($product->description ?? ''), 155))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <nav class="flex items-center gap-2 text-sm text-gray-400 mb-8">
        <a href="{{ route('home') }}" class="hover:text-brand-500 transition-colors">الرئيسية</a>
        <span>›</span>
        <a href="{{ route('products.index') }}" class="hover:text-brand-500 transition-colors">المنتجات</a>
        @if($product->category)
        <span>›</span>
        <a href="{{ route('products.index', ['category' => $product->category->slug]) }}"
           class="hover:text-brand-500 transition-colors">{{ $product->category->name }}</a>
        @endif
        <span>›</span>
        <span class="text-gray-600">{{ $product->name }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-16" x-data="{ quantity: 1, added: false }">

        {{-- Image Gallery --}}
        <div x-data="{ activeImg: '{{ $product->image ? Storage::url($product->image) : '' }}' }">
            <div class="rounded-3xl overflow-hidden shadow-xl h-96 mb-4"
                 style="background: linear-gradient(135deg, oklch(0.965 0.018 350), oklch(0.930 0.038 350))">
                @if($product->image)
                <img :src="activeImg" alt="{{ $product->name }}" class="w-full h-full object-cover">
                @else
                <div class="w-full h-full flex items-center justify-center text-9xl">🎀</div>
                @endif
            </div>
            @if($product->images->isNotEmpty())
            <div class="flex gap-3 overflow-x-auto pb-2">
                <button @click="activeImg='{{ Storage::url($product->image) }}'"
                        class="shrink-0 w-16 h-16 rounded-xl overflow-hidden border-2 hover:border-brand-400 transition-colors"
                        :class="activeImg==='{{ Storage::url($product->image) }}' ? 'border-brand-500' : 'border-transparent'">
                    <img src="{{ Storage::url($product->image) }}" alt="" class="w-full h-full object-cover">
                </button>
                @foreach($product->images as $img)
                <button @click="activeImg='{{ Storage::url($img->image) }}'"
                        class="shrink-0 w-16 h-16 rounded-xl overflow-hidden border-2 hover:border-brand-400 transition-colors"
                        :class="activeImg==='{{ Storage::url($img->image) }}' ? 'border-brand-500' : 'border-transparent'">
                    <img src="{{ Storage::url($img->image) }}" alt="" class="w-full h-full object-cover">
                </button>
                @endforeach
            </div>
            @endif
        </div>

        {{-- Details --}}
        <div>
            @if($product->category)
            <span class="text-sm text-gray-400 mb-2 block">{{ $product->category->name }}</span>
            @endif

            <h1 class="text-4xl font-black mb-3" style="color: oklch(0.22 0.01 280)">{{ $product->name }}</h1>

            <div class="flex items-center gap-4 mb-4">
                <span class="text-3xl font-black" style="color: oklch(0.66 0.157 345)">
                    {{ number_format($product->price, 2) }} ج.م
                </span>
                @if($product->isAvailable())
                <span class="text-sm text-green-600 font-semibold">✓ متاح</span>
                @else
                <span class="text-sm text-red-500 font-semibold">✕ غير متاح</span>
                @endif
            </div>

            @if($product->description)
            <div class="text-gray-600 leading-relaxed mb-6">{{ $product->description }}</div>
            @endif

            @if($product->occasions->isNotEmpty())
            <div class="flex flex-wrap gap-2 mb-6">
                @foreach($product->occasions as $occasion)
                <span class="text-sm px-3 py-1 rounded-full font-medium"
                      style="background: oklch(0.948 0.032 345); color: oklch(0.58 0.165 345)">
                    {{ $occasion->name }}
                </span>
                @endforeach
            </div>
            @endif

            @if($product->isAvailable())
            <div class="flex items-center gap-4 mb-6">
                <div class="flex items-center border-2 border-blush-200 rounded-xl overflow-hidden">
                    <button @click="quantity = Math.max(1, quantity - 1)" class="px-4 py-3 text-lg font-bold hover:bg-blush-100 transition-colors">−</button>
                    <span x-text="quantity" class="px-4 py-3 text-lg font-bold min-w-12 text-center"></span>
                    <button @click="quantity++" class="px-4 py-3 text-lg font-bold hover:bg-blush-100 transition-colors">+</button>
                </div>
                <button @click="$store.cart.addProduct({id:{{ $product->id }}, name:'{{ addslashes($product->name) }}', price:{{ $product->price }}, image:'{{ $product->image ? Storage::url($product->image) : '' }}'}, quantity); added = true; setTimeout(() => added = false, 2000)"
                        class="btn-primary flex-1 justify-center py-4 text-base"
                        :class="added ? 'opacity-80' : ''">
                    <span x-text="added ? '✓ تمت الإضافة' : '🛒 أضف إلى السلة'"></span>
                </button>
                <button @click="$store.favorites.toggle({type:'product', id:{{ $product->id }}, name:'{{ addslashes($product->name) }}', image:'{{ $product->image ? Storage::url($product->image) : '' }}'})"
                        class="p-4 rounded-xl border-2 border-blush-200 hover:border-brand-300 transition-colors text-xl">
                    <span x-text="$store.favorites.isFavorite('product', {{ $product->id }}) ? '❤️' : '🤍'"></span>
                </button>
            </div>
            <a href="{{ route('cart') }}" class="btn-secondary w-full justify-center py-3">
                🛒 إتمام الطلب عبر واتساب
            </a>
            @endif
        </div>
    </div>

    {{-- Reviews Section --}}
    <div class="mb-12" x-data="{ showReviewModal: false }">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-black">تقييمات العملاء</h2>
            <button type="button" @click="showReviewModal = !showReviewModal" class="btn-secondary text-xs py-2 px-4">
                ✍️ أضف تقييمك
            </button>
        </div>

        {{-- Review Form Accordion --}}
        <div x-show="showReviewModal" x-collapse class="card p-6 mb-6 border-brand-200 bg-brand-50/20">
            <h3 class="font-bold text-sm text-gray-900 mb-3">شاركنا رأيك في هذا المنتج</h3>
            <form action="{{ route('reviews.store') }}" method="POST" class="space-y-3">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">اسمك الكريم *</label>
                        <input type="text" name="customer_name" required placeholder="مثال: سارة أحمد" class="input-field text-xs">
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
                    <textarea name="comment" rows="2" placeholder="اكتب رأيك الصادق في المنتج..." class="input-field text-xs"></textarea>
                </div>

                <button type="submit" class="btn-primary text-xs py-2 px-5">إرسال التقييم</button>
            </form>
        </div>

        @if($product->reviews->isNotEmpty())
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($product->reviews as $review)
            <div class="card p-5">
                <div class="flex items-center gap-1 mb-2">
                    @for($i = 0; $i < $review->rating; $i++)<span class="text-yellow-400">⭐</span>@endfor
                </div>
                @if($review->comment)<p class="text-gray-600 text-sm mb-3">"{{ $review->comment }}"</p>@endif
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-bold"
                         style="background: oklch(0.66 0.157 345)">
                        {{ mb_substr($review->customer_name ?? 'م', 0, 1) }}
                    </div>
                    <span class="text-sm font-semibold">{{ $review->customer_name ?? 'عميل' }}</span>
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
        <h2 class="text-2xl font-black mb-6">منتجات مشابهة</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
            @foreach($related as $p)
            <a href="{{ route('products.show', $p->slug) }}" class="product-card group">
                @if($p->image)
                <img src="{{ Storage::url($p->image) }}" alt="{{ $p->name }}"
                     class="w-full h-40 object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
                @else
                <div class="w-full h-40 bg-blush-100 flex items-center justify-center text-4xl">🎀</div>
                @endif
                <div class="p-3">
                    <h3 class="font-semibold text-sm text-gray-800 line-clamp-1">{{ $p->name }}</h3>
                    <span class="text-sm font-bold" style="color: oklch(0.66 0.157 345)">{{ number_format($p->price, 0) }} ج.م</span>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
