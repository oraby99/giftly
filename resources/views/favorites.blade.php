@extends('layouts.app')

@section('title', 'قائمة المفضلة')
@section('meta_description', 'هداياك ومنتجاتك المفضلة المحفوظة في متجر جيفتلي للرجوع إليها لاحقاً.')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10" x-cloak>

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-xs text-gray-500 mb-6">
        <a href="{{ route('home') }}" class="hover:text-brand-600 transition-colors">الرئيسية</a>
        <span>/</span>
        <span class="text-gray-800 font-semibold">المفضلة</span>
    </nav>

    <div class="flex items-center justify-between border-b border-gray-100 pb-5 mb-8">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 flex items-center gap-2">
                <span>❤️</span> قائمة الهدايا المفضلة
            </h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">
                لديك <span class="font-bold text-brand-600" x-text="$store.favorites.count"></span> هدايا محفوظة
            </p>
        </div>
    </div>

    {{-- EMPTY STATE --}}
    <div x-show="$store.favorites.items.length === 0" class="py-16 text-center card p-8 max-w-xl mx-auto">
        <div class="w-20 h-20 mx-auto mb-5 rounded-full bg-pink-50 flex items-center justify-center text-4xl shadow-inner text-pink-500">
            🤍
        </div>
        <h2 class="text-xl font-bold text-gray-800 mb-2">قائمة مفضلتك فارغة</h2>
        <p class="text-sm text-gray-500 max-w-sm mx-auto mb-8 leading-relaxed">
            انقر على رمز القلب على أي منتج أو صندوق هدايا لحفظه في هذه القائمة والرجوع إليه متى أردت.
        </p>
        <div class="flex flex-wrap items-center justify-center gap-3">
            <a href="{{ route('gift-boxes.index') }}" class="btn-primary text-sm">
                <span>🎁 استكشف صناديق الهدايا</span>
            </a>
            <a href="{{ route('products.index') }}" class="btn-secondary text-sm">
                <span>تصفح المنتجات</span>
            </a>
        </div>
    </div>

    {{-- FAVORITES GRID --}}
    <div x-show="$store.favorites.items.length > 0" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
        <template x-for="(fav, index) in $store.favorites.items" :key="fav.type + '_' + fav.id">
            <div class="product-card group relative">

                {{-- Remove heart button --}}
                <button type="button"
                        @click="$store.favorites.toggle(fav)"
                        title="إزالة من المفضلة"
                        class="absolute top-3 left-3 z-10 w-8 h-8 rounded-full bg-white/90 backdrop-blur-xs text-red-500 flex items-center justify-center shadow-xs hover:scale-110 transition-transform">
                    ❤️
                </button>

                {{-- Image Link --}}
                <div class="relative aspect-square overflow-hidden bg-gray-50">
                    <template x-if="fav.image">
                        <img :src="'/storage/' + fav.image" :alt="fav.name" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    </template>
                    <template x-if="!fav.image">
                        <div class="w-full h-full flex items-center justify-center text-4xl text-gray-300">
                            🎁
                        </div>
                    </template>

                    <span class="absolute bottom-2 right-2 badge-price text-xs" x-text="fav.price + ' ج.م'"></span>
                </div>

                {{-- Body --}}
                <div class="product-card-body">
                    <span class="text-[11px] font-semibold text-gray-400 mb-1" x-text="fav.type === 'gift_box' ? 'صندوق هدايا' : 'منتج'"></span>
                    <h3 class="font-bold text-gray-900 text-sm mb-3 line-clamp-1" x-text="fav.name"></h3>

                    <div class="mt-auto flex flex-col gap-2">
                        <button type="button"
                                @click="fav.type === 'gift_box' ? $store.cart.addGiftBox(fav) : $store.cart.addProduct(fav)"
                                class="btn-primary text-xs py-2 w-full justify-center">
                            <span>🛒 إضافة للسلة</span>
                        </button>
                    </div>
                </div>

            </div>
        </template>
    </div>

</div>
@endsection
