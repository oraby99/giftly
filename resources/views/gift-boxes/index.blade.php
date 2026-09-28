@extends('layouts.app')

@section('title', 'صناديق الهدايا')
@section('meta_description', 'تصفح مجموعتنا من صناديق الهدايا الجاهزة للمناسبات المختلفة')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-4xl font-black mb-2" style="color: oklch(0.22 0.01 280)">صناديق الهدايا</h1>
        <p class="text-gray-500">{{ $giftBoxes->total() }} صندوق متاح</p>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">

        {{-- Sidebar Filters --}}
        <aside class="w-full lg:w-64 shrink-0">
            <form method="GET" class="card p-5 space-y-6">

                {{-- Occasion Filter --}}
                <div>
                    <h3 class="font-bold text-gray-700 mb-3">المناسبة</h3>
                    <div class="space-y-2">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="occasion" value=""
                                   {{ !request('occasion') ? 'checked' : '' }}
                                   class="text-brand-500">
                            <span class="text-sm text-gray-600">الكل</span>
                        </label>
                        @foreach($occasions as $occasion)
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="occasion" value="{{ $occasion->slug }}"
                                   {{ request('occasion') === $occasion->slug ? 'checked' : '' }}
                                   class="text-brand-500">
                            <span class="text-sm text-gray-600">{{ $occasion->name }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Price Filter --}}
                <div>
                    <h3 class="font-bold text-gray-700 mb-3">نطاق السعر</h3>
                    <div class="flex gap-2">
                        <input type="number" name="price_min" placeholder="من"
                               value="{{ request('price_min') }}"
                               class="input-field py-2 text-sm w-1/2">
                        <input type="number" name="price_max" placeholder="إلى"
                               value="{{ request('price_max') }}"
                               class="input-field py-2 text-sm w-1/2">
                    </div>
                </div>

                {{-- Sort --}}
                <div>
                    <h3 class="font-bold text-gray-700 mb-3">الترتيب</h3>
                    <select name="sort" class="input-field py-2 text-sm">
                        <option value="sort_order" {{ request('sort') !== 'price' ? 'selected' : '' }}>الافتراضي</option>
                        <option value="price" {{ request('sort') === 'price' && request('dir') !== 'desc' ? 'selected' : '' }}>السعر: الأقل أولاً</option>
                        <option value="price&dir=desc" {{ request('sort') === 'price' && request('dir') === 'desc' ? 'selected' : '' }}>السعر: الأعلى أولاً</option>
                    </select>
                </div>

                <button type="submit" class="btn-primary w-full justify-center">
                    تطبيق الفلاتر
                </button>

                @if(request()->hasAny(['occasion', 'price_min', 'price_max']))
                <a href="{{ route('gift-boxes.index') }}" class="block text-center text-sm text-gray-400 hover:text-red-500 transition-colors">
                    إزالة الفلاتر ✕
                </a>
                @endif
            </form>
        </aside>

        {{-- Products Grid --}}
        <div class="flex-1">
            {{-- Discover Inside Banner (Image 1 requested by user) --}}
            <a href="{{ $giftBoxes->first() ? route('gift-boxes.show', $giftBoxes->first()->slug) . '?open=1' : '#' }}"
               class="mb-6 p-4 sm:p-5 rounded-[24px] border border-gray-900 bg-white flex flex-col sm:flex-row items-center justify-between gap-4 shadow-xs hover:shadow-md transition-all group block">
                <div class="text-right">
                    <h3 class="font-black text-base sm:text-lg text-gray-900 leading-tight">محتويات البوكس وتعليمات التجهيز</h3>
                    <p class="text-xs sm:text-sm text-gray-500 mt-1">شاهد قائمة الهدايا وما سنطلبه منك لتجهيز الهدية</p>
                </div>
                <div class="px-5 sm:px-6 py-2.5 rounded-full text-white font-extrabold text-xs sm:text-sm shadow-md shrink-0 group-hover:scale-105 transition-transform"
                     style="background: linear-gradient(135deg, #a42c67 0%, #b83677 100%);">
                    <span>اكتشف اللي جواه ↓</span>
                </div>
            </a>

            @if($giftBoxes->isEmpty())
            <div class="text-center py-20">
                <div class="text-5xl mb-4">🎁</div>
                <h3 class="text-xl font-bold text-gray-600 mb-2">لا توجد نتائج</h3>
                <p class="text-gray-400">جرب تغيير الفلاتر أو تصفح جميع الصناديق</p>
            </div>
            @else
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach($giftBoxes as $box)
                <div class="product-card group" x-data="{ added: false }">
                    <div class="relative overflow-hidden">
                        <a href="{{ route('gift-boxes.show', $box->slug) }}?open=1" class="block">
                            @if($box->image)
                            <img src="{{ Storage::url($box->image) }}"
                                 alt="{{ $box->name }}"
                                 class="w-full h-56 object-cover group-hover:scale-105 transition-transform duration-300"
                                 loading="lazy">
                            @else
                            <div class="w-full h-56 flex items-center justify-center text-6xl"
                                 style="background: linear-gradient(135deg, oklch(0.965 0.018 350), oklch(0.930 0.038 350))">
                                🎁
                            </div>
                            @endif
                            <div class="absolute bottom-2.5 inset-x-2.5 bg-white/95 backdrop-blur-xs py-1.5 px-3 rounded-xl text-xs font-bold text-pink-600 flex items-center justify-between shadow-sm group-hover:text-pink-700 transition-colors">
                                <span>اكتشف اللي جواه ↓</span>
                                <span>🎁</span>
                            </div>
                        </a>
                        <button @click="$store.favorites.toggle({type:'gift_box', id:{{ $box->id }}, name:'{{ addslashes($box->name) }}', image:'{{ $box->image ? Storage::url($box->image) : '' }}'})"
                                class="absolute top-3 left-3 w-9 h-9 bg-white/90 backdrop-blur rounded-full flex items-center justify-center shadow-md hover:scale-110 transition-transform">
                            <span x-text="$store.favorites.isFavorite('gift_box', {{ $box->id }}) ? '❤️' : '🤍'"></span>
                        </button>
                        @if($box->is_featured)
                        <span class="absolute top-3 right-3 text-xs font-bold text-white px-2 py-1 rounded-full"
                              style="background: oklch(0.66 0.157 345)">⭐ مميز</span>
                        @endif
                    </div>
                    <div class="product-card-body">
                        <a href="{{ route('gift-boxes.show', $box->slug) }}">
                            <h3 class="font-bold text-gray-800 mb-2 line-clamp-2 hover:text-brand-600 transition-colors">
                                {{ $box->name }}
                            </h3>
                        </a>
                        <div class="flex flex-wrap gap-1 mb-2">
                            @foreach($box->occasions->take(3) as $occasion)
                            <span class="text-xs px-2 py-0.5 rounded-full font-medium"
                                  style="background: oklch(0.948 0.032 345); color: oklch(0.49 0.155 345)">
                                {{ $occasion->name }}
                            </span>
                            @endforeach
                        </div>

                        {{-- Direct Discover Inside link on the card before entering --}}
                        <a href="{{ route('gift-boxes.show', $box->slug) }}?open=1"
                           class="mb-3 py-1.5 px-3 rounded-xl bg-pink-50 hover:bg-pink-100 text-pink-700 font-bold text-xs border border-pink-200 flex items-center justify-between transition-colors">
                            <span class="text-gray-700">محتويات البوكس</span>
                            <span class="text-pink-600 font-extrabold flex items-center gap-1">
                                <span>اكتشف اللي جواه ↓</span>
                            </span>
                        </a>

                        <div class="mt-auto flex items-center justify-between">
                            <span class="badge-price">{{ number_format($box->price, 0) }} ج.م</span>
                            <button @click="$store.cart.addGiftBox({id:{{ $box->id }}, name:'{{ addslashes($box->name) }}', price:{{ $box->price }}, image:'{{ $box->image ? Storage::url($box->image) : '' }}'}); window.location.href = '{{ route('cart') }}'"
                                    class="btn-primary py-2 px-4 text-sm">
                                <span>+ إضافة للسلة</span>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $giftBoxes->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
