@extends('layouts.app')

@section('title', 'المنتجات')
@section('meta_description', 'تصفح مجموعتنا الكاملة من منتجات الهدايا')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="mb-8">
        <h1 class="text-4xl font-black mb-2" style="color: oklch(0.22 0.01 280)">المنتجات</h1>
        <p class="text-gray-500">{{ $products->total() }} منتج متاح</p>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">
        <aside class="w-full lg:w-64 shrink-0">
            <form method="GET" class="card p-5 space-y-5">
                <div>
                    <input type="text" name="q" value="{{ request('q') }}"
                           placeholder="ابحث عن منتج..."
                           class="input-field text-sm py-2">
                </div>

                <div>
                    <h3 class="font-bold text-gray-700 mb-3">التصنيف</h3>
                    <div class="space-y-2">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="category" value="" {{ !request('category') ? 'checked' : '' }}>
                            <span class="text-sm">الكل</span>
                        </label>
                        @foreach($categories as $category)
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="category" value="{{ $category->slug }}"
                                   {{ request('category') === $category->slug ? 'checked' : '' }}>
                            <span class="text-sm">{{ $category->name }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <div>
                    <h3 class="font-bold text-gray-700 mb-3">المناسبة</h3>
                    <div class="space-y-2">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="occasion" value="" {{ !request('occasion') ? 'checked' : '' }}>
                            <span class="text-sm">الكل</span>
                        </label>
                        @foreach($occasions as $occasion)
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="occasion" value="{{ $occasion->slug }}"
                                   {{ request('occasion') === $occasion->slug ? 'checked' : '' }}>
                            <span class="text-sm">{{ $occasion->name }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <div>
                    <h3 class="font-bold text-gray-700 mb-3">السعر</h3>
                    <div class="flex gap-2">
                        <input type="number" name="price_min" placeholder="من" value="{{ request('price_min') }}"
                               class="input-field py-2 text-sm w-1/2">
                        <input type="number" name="price_max" placeholder="إلى" value="{{ request('price_max') }}"
                               class="input-field py-2 text-sm w-1/2">
                    </div>
                </div>

                <button type="submit" class="btn-primary w-full justify-center">تطبيق</button>

                @if(request()->hasAny(['q', 'category', 'occasion', 'price_min', 'price_max']))
                <a href="{{ route('products.index') }}" class="block text-center text-sm text-gray-400 hover:text-red-500 transition-colors">
                    إزالة الفلاتر ✕
                </a>
                @endif
            </form>
        </aside>

        <div class="flex-1">
            @if($products->isEmpty())
            <div class="text-center py-20">
                <div class="text-5xl mb-4">🔍</div>
                <h3 class="text-xl font-bold text-gray-600 mb-2">لا توجد منتجات</h3>
                <p class="text-gray-400">جرب تغيير معايير البحث</p>
            </div>
            @else
            <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                @foreach($products as $product)
                <div class="product-card group" x-data="{ added: false }">
                    <div class="relative overflow-hidden">
                        <a href="{{ route('products.show', $product->slug) }}">
                            @if($product->image)
                            <img src="{{ Storage::url($product->image) }}"
                                 alt="{{ $product->name }}"
                                 class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300"
                                 loading="lazy">
                            @else
                            <div class="w-full h-48 flex items-center justify-center text-5xl bg-blush-100">🎀</div>
                            @endif
                        </a>
                        <button @click="$store.favorites.toggle({type:'product', id:{{ $product->id }}, name:'{{ addslashes($product->name) }}', image:'{{ $product->image ? Storage::url($product->image) : '' }}'})"
                                class="absolute top-2 left-2 w-8 h-8 bg-white/90 backdrop-blur rounded-full flex items-center justify-center shadow text-sm hover:scale-110 transition-transform">
                            <span x-text="$store.favorites.isFavorite('product', {{ $product->id }}) ? '❤️' : '🤍'"></span>
                        </button>
                    </div>
                    <div class="product-card-body">
                        <a href="{{ route('products.show', $product->slug) }}">
                            <h3 class="font-semibold text-gray-800 text-sm mb-1 line-clamp-2 hover:text-brand-600 transition-colors">
                                {{ $product->name }}
                            </h3>
                        </a>
                        @if($product->category)
                        <span class="text-xs text-gray-400">{{ $product->category->name }}</span>
                        @endif
                        <div class="mt-auto pt-3 flex items-center justify-between">
                            <span class="font-bold text-sm" style="color: oklch(0.66 0.157 345)">
                                {{ number_format($product->price, 0) }} ج.م
                            </span>
                            <button @click="$store.cart.addProduct({id:{{ $product->id }}, name:'{{ addslashes($product->name) }}', price:{{ $product->price }}, image:'{{ $product->image ? Storage::url($product->image) : '' }}'}); added = true; setTimeout(() => added = false, 2000)"
                                    class="btn-primary py-1.5 px-3 text-xs"
                                    :class="added ? 'opacity-75' : ''">
                                <span x-text="added ? '✓' : '+ سلة'"></span>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="mt-8">{{ $products->links() }}</div>
            @endif
        </div>
    </div>
</div>
@endsection
