<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Giftly - متجر الهدايا') | جيفتلي</title>
    <meta name="description" content="@yield('meta_description', 'جيفتلي - متجر هدايا متميز يقدم صناديق هدايا جاهزة ومخصصة للمناسبات المختلفة')">

    <meta property="og:title" content="@yield('title', 'Giftly - متجر الهدايا')">
    <meta property="og:description" content="@yield('meta_description', 'جيفتلي - متجر هدايا متميز')">
    <meta property="og:type" content="website">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="min-h-screen flex flex-col pb-20 lg:pb-0" x-data="giftlyApp()">

    {{-- Top Navigation Header --}}
    <header class="bg-white/95 backdrop-blur-md border-b border-blush-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 gap-3">

                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-2 shrink-0">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center text-white font-bold text-lg shadow-sm"
                         style="background: linear-gradient(135deg, oklch(0.66 0.157 345), oklch(0.49 0.155 345))">
                        🎁
                    </div>
                    <span class="font-extrabold text-xl tracking-tight" style="color: oklch(0.49 0.155 345)">جيفتلي</span>
                </a>

                {{-- Search Bar (Desktop) --}}
                <div class="flex-1 max-w-md hidden md:block">
                    <form action="{{ route('products.index') }}" method="GET">
                        <div class="relative">
                            <input type="text"
                                   name="q"
                                   placeholder="ابحث عن منتج، شوكولاتة، زهور، صندوق..."
                                   class="input-field pl-10 pr-4 py-2 text-sm">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">🔍</span>
                        </div>
                    </form>
                </div>

                {{-- Desktop Nav Links --}}
                <nav class="hidden lg:flex items-center gap-6">
                    <a href="{{ route('gift-boxes.index') }}" class="nav-link text-sm {{ request()->routeIs('gift-boxes.*') ? 'text-brand-600 font-bold' : '' }}">صناديق الهدايا</a>
                    <a href="{{ route('products.index') }}" class="nav-link text-sm {{ request()->routeIs('products.*') ? 'text-brand-600 font-bold' : '' }}">المنتجات</a>
                    <a href="{{ route('custom-box-builder') }}" class="nav-link text-sm {{ request()->routeIs('custom-box-builder') ? 'text-brand-600 font-bold' : '' }}">اصنع صندوقك ✨</a>
                    <a href="{{ route('corporate.index') }}" class="nav-link text-sm {{ request()->routeIs('corporate.*') ? 'text-brand-600 font-bold' : '' }}">هدايا الشركات</a>
                    <a href="{{ route('home') }}#customer-reviews" class="nav-link text-sm hover:text-brand-600">آراء العملاء</a>
                </nav>

                {{-- Actions: Favorites, Cart & Mobile Menu Toggle --}}
                <div class="flex items-center gap-2 sm:gap-3">
                    {{-- Search Icon for Mobile --}}
                    <a href="{{ route('products.index') }}"
                       class="md:hidden p-2 text-gray-600 hover:text-brand-600 transition-colors"
                       title="بحث">
                        🔍
                    </a>

                    {{-- Favorites Link --}}
                    <a href="{{ route('favorites') }}"
                       class="relative p-2 text-gray-600 hover:text-brand-600 transition-colors"
                       title="المفضلة">
                        ❤️
                        <span x-cloak
                              x-show="favoritesCount > 0"
                              x-text="favoritesCount"
                              class="absolute -top-1 -right-1 text-white text-[10px] w-4 h-4 rounded-full flex items-center justify-center font-bold"
                              style="background: oklch(0.66 0.157 345)"></span>
                    </a>

                    {{-- Cart Link --}}
                    <a href="{{ route('cart') }}"
                       class="relative flex items-center gap-1.5 btn-primary py-2 px-3.5 sm:px-4 text-xs sm:text-sm shadow-xs">
                        <span>🛒</span>
                        <span class="hidden sm:inline">السلة</span>
                        <span x-cloak
                              x-show="cartCount > 0"
                              x-text="cartCount"
                              class="bg-white/30 text-white text-xs px-1.5 rounded-full font-bold ml-0.5"></span>
                    </a>

                    {{-- Mobile Hamburger Button --}}
                    <button type="button"
                            @click="mobileMenuOpen = !mobileMenuOpen"
                            class="lg:hidden p-2 rounded-xl border border-gray-200 text-gray-600 hover:text-brand-600 hover:bg-brand-50 transition-colors focus:outline-none"
                            aria-label="القائمة الرئيسية">
                        <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        <svg x-cloak x-show="mobileMenuOpen" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Mobile Dropdown / Slide Menu --}}
            <div x-cloak
                 x-show="mobileMenuOpen"
                 x-collapse
                 class="lg:hidden border-t border-blush-200 py-4 space-y-2 bg-white">
                <form action="{{ route('products.index') }}" method="GET" class="mb-3">
                    <div class="relative">
                        <input type="text" name="q" placeholder="ابحث عن هدية أو منتج..." class="input-field text-xs pl-8">
                        <span class="absolute left-2.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs">🔍</span>
                    </div>
                </form>

                <div class="grid grid-cols-1 gap-1 text-sm font-semibold">
                    <a href="{{ route('home') }}"
                       @click="mobileMenuOpen = false"
                       class="px-3 py-2.5 rounded-xl hover:bg-brand-50 hover:text-brand-600 flex items-center gap-2 {{ request()->routeIs('home') ? 'bg-brand-50 text-brand-600' : 'text-gray-700' }}">
                        <span>🏠</span> الرئيسية
                    </a>
                    <a href="{{ route('gift-boxes.index') }}"
                       @click="mobileMenuOpen = false"
                       class="px-3 py-2.5 rounded-xl hover:bg-brand-50 hover:text-brand-600 flex items-center gap-2 {{ request()->routeIs('gift-boxes.*') ? 'bg-brand-50 text-brand-600' : 'text-gray-700' }}">
                        <span>🎁</span> صناديق الهدايا
                    </a>
                    <a href="{{ route('products.index') }}"
                       @click="mobileMenuOpen = false"
                       class="px-3 py-2.5 rounded-xl hover:bg-brand-50 hover:text-brand-600 flex items-center gap-2 {{ request()->routeIs('products.*') ? 'bg-brand-50 text-brand-600' : 'text-gray-700' }}">
                        <span>🛍️</span> المنتجات
                    </a>
                    <a href="{{ route('custom-box-builder') }}"
                       @click="mobileMenuOpen = false"
                       class="px-3 py-2.5 rounded-xl hover:bg-brand-50 hover:text-brand-600 flex items-center gap-2 {{ request()->routeIs('custom-box-builder') ? 'bg-brand-50 text-brand-600' : 'text-gray-700' }}">
                        <span>✨</span> اصنع صندوقك الخاص
                    </a>
                    <a href="{{ route('corporate.index') }}"
                       @click="mobileMenuOpen = false"
                       class="px-3 py-2.5 rounded-xl hover:bg-brand-50 hover:text-brand-600 flex items-center gap-2 {{ request()->routeIs('corporate.*') ? 'bg-brand-50 text-brand-600' : 'text-gray-700' }}">
                        <span>🏢</span> هدايا الشركات
                    </a>
                    <a href="{{ route('home') }}#customer-reviews"
                       @click="mobileMenuOpen = false"
                       class="px-3 py-2.5 rounded-xl hover:bg-brand-50 hover:text-brand-600 flex items-center gap-2 text-gray-700">
                        <span>⭐</span> آراء العملاء
                    </a>
                    <a href="{{ route('favorites') }}"
                       @click="mobileMenuOpen = false"
                       class="px-3 py-2.5 rounded-xl hover:bg-brand-50 hover:text-brand-600 flex items-center gap-2 {{ request()->routeIs('favorites') ? 'bg-brand-50 text-brand-600' : 'text-gray-700' }}">
                        <span>❤️</span> المفضلة
                    </a>
                    <a href="{{ route('about') }}"
                       @click="mobileMenuOpen = false"
                       class="px-3 py-2.5 rounded-xl hover:bg-brand-50 hover:text-brand-600 flex items-center gap-2 {{ request()->routeIs('about') ? 'bg-brand-50 text-brand-600' : 'text-gray-700' }}">
                        <span>📖</span> من نحن
                    </a>
                    <a href="{{ route('contact') }}"
                       @click="mobileMenuOpen = false"
                       class="px-3 py-2.5 rounded-xl hover:bg-brand-50 hover:text-brand-600 flex items-center gap-2 {{ request()->routeIs('contact') ? 'bg-brand-50 text-brand-600' : 'text-gray-700' }}">
                        <span>💬</span> تواصل معنا
                    </a>
                </div>

                <div class="pt-3 border-t border-gray-100 flex items-center justify-between text-xs text-gray-500">
                    <span>تحتاج مساعدة فورية؟</span>
                    <a href="https://wa.me/201112126939" target="_blank" class="text-green-600 font-bold flex items-center gap-1 hover:underline">
                        <span>💬</span> واتساب خدمة العملاء
                    </a>
                </div>
            </div>
        </div>
    </header>

    {{-- Mobile Bottom Sticky Navigation Bar --}}
    <nav class="fixed bottom-0 left-0 right-0 z-40 bg-white/95 backdrop-blur-md border-t border-blush-200 lg:hidden shadow-lg px-2 py-1.5">
        <div class="flex items-center justify-around text-center">
            {{-- Home --}}
            <a href="{{ route('home') }}"
               class="flex flex-col items-center gap-0.5 py-1 px-2 rounded-xl transition-colors {{ request()->routeIs('home') ? 'text-brand-600 font-bold' : 'text-gray-500 hover:text-gray-900' }}">
                <span class="text-lg">🏠</span>
                <span class="text-[10px]">الرئيسية</span>
            </a>

            {{-- Gift Boxes --}}
            <a href="{{ route('gift-boxes.index') }}"
               class="flex flex-col items-center gap-0.5 py-1 px-2 rounded-xl transition-colors {{ request()->routeIs('gift-boxes.*') ? 'text-brand-600 font-bold' : 'text-gray-500 hover:text-gray-900' }}">
                <span class="text-lg">🎁</span>
                <span class="text-[10px]">الصناديق</span>
            </a>

            {{-- Custom Builder Center Button --}}
            <a href="{{ route('custom-box-builder') }}"
               class="flex flex-col items-center -mt-4 group">
                <div class="w-12 h-12 rounded-full flex items-center justify-center text-white text-xl shadow-md group-hover:scale-105 transition-transform"
                     style="background: linear-gradient(135deg, oklch(0.66 0.157 345), oklch(0.49 0.155 345))">
                    ✨
                </div>
                <span class="text-[10px] font-bold mt-0.5" style="color: oklch(0.49 0.155 345)">صمم صندوقك</span>
            </a>

            {{-- Favorites --}}
            <a href="{{ route('favorites') }}"
               class="relative flex flex-col items-center gap-0.5 py-1 px-2 rounded-xl transition-colors {{ request()->routeIs('favorites') ? 'text-brand-600 font-bold' : 'text-gray-500 hover:text-gray-900' }}">
                <span class="text-lg">❤️</span>
                <span class="text-[10px]">المفضلة</span>
                <span x-cloak
                      x-show="favoritesCount > 0"
                      x-text="favoritesCount"
                      class="absolute top-0 right-1 text-white text-[9px] w-3.5 h-3.5 rounded-full flex items-center justify-center font-bold"
                      style="background: oklch(0.66 0.157 345)"></span>
            </a>

            {{-- Cart --}}
            <a href="{{ route('cart') }}"
               class="relative flex flex-col items-center gap-0.5 py-1 px-2 rounded-xl transition-colors {{ request()->routeIs('cart') ? 'text-brand-600 font-bold' : 'text-gray-500 hover:text-gray-900' }}">
                <span class="text-lg">🛒</span>
                <span class="text-[10px]">السلة</span>
                <span x-cloak
                      x-show="cartCount > 0"
                      x-text="cartCount"
                      class="absolute top-0 right-1 text-white text-[9px] w-3.5 h-3.5 rounded-full flex items-center justify-center font-bold"
                      style="background: oklch(0.66 0.157 345)"></span>
            </a>
        </div>
    </nav>

    {{-- Flash Messages --}}
    @if(session('success'))
    <div class="bg-green-50 border-b border-green-200 text-green-800 text-sm px-6 py-3 text-center">
        ✅ {{ session('success') }}
    </div>
    @endif

    {{-- Main Content --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-gray-900 text-gray-300 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">

                <div class="md:col-span-2">
                    <div class="flex items-center gap-2 mb-4">
                        <span class="text-2xl">🎁</span>
                        <span class="font-extrabold text-2xl text-white">جيفتلي</span>
                    </div>
                    <p class="text-sm leading-relaxed text-gray-400 max-w-xs">
                        متجر الهدايا المتميز للمناسبات الخاصة. صناديق هدايا جاهزة ومخصصة بأفضل الأسعار.
                    </p>
                    <div class="flex items-center gap-4 mt-6">
                        <a href="#" class="text-gray-400 hover:text-pink-400 transition-colors text-lg">📘</a>
                        <a href="#" class="text-gray-400 hover:text-pink-400 transition-colors text-lg">📸</a>
                        <a href="#" class="text-gray-400 hover:text-pink-400 transition-colors text-lg">🐦</a>
                    </div>
                </div>

                <div>
                    <h4 class="font-bold text-white mb-4">روابط سريعة</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('gift-boxes.index') }}" class="hover:text-white transition-colors">صناديق الهدايا</a></li>
                        <li><a href="{{ route('products.index') }}" class="hover:text-white transition-colors">المنتجات</a></li>
                        <li><a href="{{ route('custom-box-builder') }}" class="hover:text-white transition-colors">اصنع صندوقك</a></li>
                        <li><a href="{{ route('corporate.index') }}" class="hover:text-white transition-colors">هدايا الشركات</a></li>
                        <li><a href="{{ route('home') }}#customer-reviews" class="hover:text-white transition-colors">آراء العملاء</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-white transition-colors">من نحن</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-white transition-colors">تواصل معنا</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold text-white mb-4">تواصل معنا</h4>
                    <div class="space-y-3 text-sm">
                        <p class="flex items-center gap-2">
                            <span>📍</span> القاهرة، مصر
                        </p>
                        <p class="flex items-center gap-2">
                            <span>📞</span> <a href="tel:+201112126939" class="hover:text-white transition-colors" dir="ltr">+20 11 1212 6939</a>
                        </p>
                        <a href="https://wa.me/201112126939" target="_blank" class="flex items-center gap-2 text-green-400 hover:text-green-300 transition-colors">
                            <span>💬</span> واتساب
                        </a>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-8 pt-6 text-center text-xs text-gray-500">
                © {{ date('Y') }} جيفتلي. جميع الحقوق محفوظة.
            </div>
        </div>
    </footer>

</body>
</html>
