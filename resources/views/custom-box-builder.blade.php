@extends('layouts.app')

@section('title', 'اصنع صندوقك الخاص')
@section('meta_description', 'صمم صندوق هدايا مخصص بالكامل، اختر نوع العلبة والمنتجات وبطاقة الإهداء بالرسالة الشخصية.')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10" x-data="customBoxBuilder()" x-cloak>

    {{-- Header Banner --}}
    <div class="text-center max-w-3xl mx-auto mb-10">
        <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-semibold bg-brand-50 text-brand-600 border border-brand-200 mb-3">
            ✨ تجربة إهداء فريدة من نوعها
        </span>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mb-3">
            اصنع <span style="color: oklch(0.58 0.165 345)">صندوق هداياك المخصص</span>
        </h1>
        <p class="text-gray-600 text-sm sm:text-base leading-relaxed">
            اختر نوع العلبة الفاخرة، انتقِ المنتجات المفضلة بعناية، واكتب رسالتك الخاصة لنصنع منها هدية لا تُنسى.
        </p>
    </div>

    {{-- Steps Wizard Bar --}}
    <div class="mb-10">
        <div class="flex items-center justify-between max-w-3xl mx-auto relative">
            <div class="absolute top-1/2 left-0 right-0 h-1 bg-gray-200 -translate-y-1/2 -z-0"></div>
            <div class="absolute top-1/2 right-0 h-1 bg-brand-500 -translate-y-1/2 transition-all duration-300 -z-0"
                 :style="'width: ' + ((step - 1) / 3 * 100) + '%'"></div>

            <template x-for="(s, index) in steps" :key="s.id">
                <button @click="if (canGoToStep(s.id)) step = s.id"
                        class="relative z-10 flex flex-col items-center gap-1.5 focus:outline-none group">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm transition-all"
                         :class="{
                            'bg-brand-500 text-white shadow-md scale-110 ring-4 ring-brand-100': step === s.id,
                            'bg-brand-600 text-white': step > s.id,
                            'bg-white text-gray-400 border-2 border-gray-300': step < s.id
                         }"
                         style="background: step === s.id || step > s.id ? 'oklch(0.58 0.165 345)' : ''">
                        <span x-show="step > s.id">✓</span>
                        <span x-show="step <= s.id" x-text="s.id"></span>
                    </div>
                    <span class="text-xs font-semibold whitespace-nowrap hidden sm:block"
                          :class="step === s.id ? 'text-brand-600 font-bold' : (step > s.id ? 'text-gray-700' : 'text-gray-400')"
                          x-text="s.title"></span>
                </button>
            </template>
        </div>
    </div>

    {{-- Main Builder Grid (Left Steps, Right Summary Sidebar) --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

        {{-- Left 2 Cols: Step Content --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- STEP 1: Box & Packaging Selection --}}
            <div x-show="step === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="card p-6">
                <div class="border-b border-gray-100 pb-4 mb-6">
                    <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                        <span>📦</span> الخطوة 1: اختر نوع الصندوق والتغليف
                    </h2>
                    <p class="text-xs text-gray-500 mt-1">اختر التصميم الذي يناسب المناسبة ومستوى الفخامة المطلوب</p>
                </div>

                {{-- Occasion Selector --}}
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">المناسبة (اختياري)</label>
                    <div class="flex flex-wrap gap-2">
                        <button type="button"
                                @click="occasion = ''"
                                class="px-3 py-1.5 rounded-full text-xs font-medium border transition-all"
                                :class="occasion === '' ? 'bg-brand-500 text-white border-brand-500 shadow-sm' : 'bg-gray-50 text-gray-600 border-gray-200 hover:bg-gray-100'">
                            عامة / غير محدد
                        </button>
                        @foreach($occasions as $occ)
                            <button type="button"
                                    @click="occasion = '{{ $occ->name }}'"
                                    class="px-3 py-1.5 rounded-full text-xs font-medium border transition-all"
                                    :class="occasion === '{{ $occ->name }}' ? 'bg-brand-500 text-white border-brand-500 shadow-sm' : 'bg-gray-50 text-gray-600 border-gray-200 hover:bg-gray-100'">
                                {{ $occ->name }}
                            </button>
                        @endforeach
                    </div>
                </div>

                {{-- Packaging Grid --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @forelse($packagingOptions as $option)
                        <div @click="selectPackaging({{ $option->id }}, '{{ addslashes($option->name) }}', {{ $option->price }})"
                             class="cursor-pointer border-2 rounded-2xl p-5 transition-all hover:shadow-md relative flex flex-col justify-between"
                             :class="packagingId === {{ $option->id }} ? 'border-brand-500 bg-brand-50/40 shadow-sm' : 'border-gray-200 hover:border-brand-200 bg-white'">

                            <div class="flex items-start justify-between gap-3 mb-3">
                                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl"
                                     style="background: oklch(0.95 0.03 345)">
                                    🎁
                                </div>
                                <span class="badge-price text-xs">
                                    {{ $option->price > 0 ? $option->price . ' ج.م' : 'مجاني' }}
                                </span>
                            </div>

                            <div>
                                <h3 class="font-bold text-gray-900 text-base mb-1">{{ $option->name }}</h3>
                                <p class="text-xs text-gray-500 leading-relaxed">{{ $option->description ?? 'صندوق أنيق ومميز مع شرائط تزيين وحشو حماية فاخر.' }}</p>
                            </div>

                            <div class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between text-xs font-semibold"
                                 :class="packagingId === {{ $option->id }} ? 'text-brand-600' : 'text-gray-400'">
                                <span x-text="packagingId === {{ $option->id }} ? '✓ تم الاختيار' : 'انقر للاختيار'"></span>
                                <span class="w-5 h-5 rounded-full border flex items-center justify-center"
                                      :class="packagingId === {{ $option->id }} ? 'bg-brand-500 border-brand-500 text-white text-[10px]' : 'border-gray-300'">
                                    <span x-show="packagingId === {{ $option->id }}">✓</span>
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-2 text-center py-6 text-gray-500 text-sm">
                            صندوق الهدايا القياسي مشمول تلقائياً.
                        </div>
                    @endforelse
                </div>

                <div class="mt-8 flex justify-end">
                    <button type="button"
                            @click="step = 2"
                            :disabled="!packagingId"
                            class="btn-primary"
                            :class="{'opacity-50 cursor-not-allowed': !packagingId}">
                        <span>التالي: اختيار المنتجات</span>
                        <span>←</span>
                    </button>
                </div>
            </div>

            {{-- STEP 2: Products Selection --}}
            <div x-show="step === 2" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="card p-6">
                <div class="border-b border-gray-100 pb-4 mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                            <span>🛍️</span> الخطوة 2: اختر محتويات الصندوق
                        </h2>
                        <p class="text-xs text-gray-500 mt-1">اختر المنتجات التي ترغب في وضعها داخل الصندوق (منتج واحد على الأقل)</p>
                    </div>
                    <div class="text-xs bg-brand-50 text-brand-700 px-3 py-1.5 rounded-lg border border-brand-200 font-semibold self-start sm:self-auto">
                        المختار: <span x-text="totalSelectedItemsCount"></span> منتجات
                    </div>
                </div>

                {{-- Filter by Category & Search --}}
                <div class="space-y-3 mb-6">
                    <div class="flex items-center gap-2">
                        <div class="relative flex-1">
                            <input type="text"
                                   x-model="searchQuery"
                                   @input.debounce.300ms="fetchProducts(1)"
                                   placeholder="ابحث عن شوكولاتة، زهور، شموع، مجات..."
                                   class="input-field pl-9 pr-3 py-2 text-sm">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs">🔍</span>
                        </div>
                    </div>

                    {{-- Category Pills --}}
                    <div class="flex items-center gap-1.5 overflow-x-auto pb-2 scrollbar-thin">
                        <button type="button"
                                @click="selectedCategory = ''; fetchProducts(1)"
                                class="px-3 py-1 rounded-full text-xs font-medium whitespace-nowrap transition-all"
                                :class="selectedCategory === '' ? 'bg-brand-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'">
                            الكل
                        </button>
                        @foreach($categories as $category)
                            <button type="button"
                                    @click="selectedCategory = '{{ $category->id }}'; fetchProducts(1)"
                                    class="px-3 py-1 rounded-full text-xs font-medium whitespace-nowrap transition-all"
                                    :class="selectedCategory === '{{ $category->id }}' ? 'bg-brand-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'">
                                {{ $category->name }}
                            </button>
                        @endforeach
                    </div>
                </div>

                {{-- Loading State --}}
                <div x-show="loadingProducts" class="py-12 text-center text-gray-400 text-sm">
                    <span class="inline-block animate-spin text-2xl mb-2">⏳</span>
                    <p>جارٍ تحميل المنتجات...</p>
                </div>

                {{-- Products Grid --}}
                <div x-show="!loadingProducts" class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                    <template x-for="prod in availableProducts" :key="prod.id">
                        <div class="border rounded-2xl p-3 bg-white hover:border-brand-300 transition-all flex flex-col justify-between group shadow-sm">
                            <div>
                                <div class="relative w-full aspect-square rounded-xl bg-gray-50 overflow-hidden mb-2.5">
                                    <template x-if="prod.image">
                                        <img :src="typeof formatImageUrl === 'function' ? formatImageUrl(prod.image) : (prod.image.startsWith('/storage') || prod.image.startsWith('http') ? prod.image : '/storage/' + prod.image)"
                                             :alt="prod.name"
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                             onerror="this.style.display='none'; if(this.parentElement.querySelector('.builder-fallback')) this.parentElement.querySelector('.builder-fallback').style.display='flex';">
                                    </template>
                                    <div class="builder-fallback w-full h-full flex items-center justify-center text-3xl text-gray-300"
                                         :style="prod.image ? 'display: none;' : 'display: flex;'">
                                        🎁
                                    </div>
                                    <span class="absolute top-2 left-2 badge-price text-[11px] px-2 py-0.5" x-text="prod.price + ' ج.م'"></span>
                                </div>
                                <h4 class="font-bold text-gray-900 text-xs sm:text-sm line-clamp-2 mb-1" x-text="prod.name"></h4>
                            </div>

                            <div class="mt-3 pt-2 border-t border-gray-50 flex items-center justify-between">
                                <template x-if="getProductQty(prod.id) === 0">
                                    <button type="button"
                                            @click="addProduct(prod)"
                                            class="w-full py-1.5 px-3 rounded-lg text-xs font-semibold text-brand-600 bg-brand-50 hover:bg-brand-100 border border-brand-200 transition-colors flex items-center justify-center gap-1">
                                        <span>+</span> إضافة للصندوق
                                    </button>
                                </template>
                                <template x-if="getProductQty(prod.id) > 0">
                                    <div class="w-full flex items-center justify-between bg-brand-50 rounded-lg p-1 border border-brand-200">
                                        <button type="button"
                                                @click="removeProduct(prod.id)"
                                                class="w-6 h-6 rounded-md bg-white text-brand-600 font-bold flex items-center justify-center shadow-xs hover:bg-red-50 hover:text-red-600 text-xs">
                                            -
                                        </button>
                                        <span class="text-xs font-bold text-brand-700" x-text="getProductQty(prod.id)"></span>
                                        <button type="button"
                                                @click="addProduct(prod)"
                                                class="w-6 h-6 rounded-md bg-brand-500 text-white font-bold flex items-center justify-center shadow-xs hover:bg-brand-600 text-xs"
                                                style="background: oklch(0.58 0.165 345)">
                                            +
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </template>
                </div>

                {{-- Pagination controls --}}
                <div x-show="pagination.last_page > 1" class="mt-6 flex justify-center gap-2">
                    <button type="button"
                            @click="fetchProducts(pagination.current_page - 1)"
                            :disabled="pagination.current_page <= 1"
                            class="px-3 py-1 text-xs rounded border border-gray-200 disabled:opacity-40">
                        السابق
                    </button>
                    <span class="text-xs text-gray-500 py-1" x-text="'صفحة ' + pagination.current_page + ' من ' + pagination.last_page"></span>
                    <button type="button"
                            @click="fetchProducts(pagination.current_page + 1)"
                            :disabled="pagination.current_page >= pagination.last_page"
                            class="px-3 py-1 text-xs rounded border border-gray-200 disabled:opacity-40">
                        التالي
                    </button>
                </div>

                <div class="mt-8 flex items-center justify-between border-t border-gray-100 pt-5">
                    <button type="button" @click="step = 1" class="btn-secondary text-sm">
                        <span>→ السابق: العلبة</span>
                    </button>
                    <button type="button"
                            @click="step = 3"
                            :disabled="selectedProducts.length === 0"
                            class="btn-primary text-sm"
                            :class="{'opacity-50 cursor-not-allowed': selectedProducts.length === 0}">
                        <span>التالي: بطاقة الإهداء والرسالة</span>
                        <span>←</span>
                    </button>
                </div>
            </div>

            {{-- STEP 3: Gift Card & Message --}}
            <div x-show="step === 3" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="card p-6">
                <div class="border-b border-gray-100 pb-4 mb-6">
                    <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                        <span>💌</span> الخطوة 3: بطاقة الإهداء والرسالة الشخصية
                    </h2>
                    <p class="text-xs text-gray-500 mt-1">نطبع رسالتك بعناية على بطاقة إهداء فاخرة مجاناً مع الصندوق</p>
                </div>

                <div class="space-y-5">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">اسم المرسل إليه (المُهدى له)</label>
                            <input type="text"
                                   x-model="recipientName"
                                   placeholder="مثال: سارة، أحمد..."
                                   class="input-field text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">صلة القرابة / الصفة (اختياري)</label>
                            <input type="text"
                                   x-model="recipientType"
                                   placeholder="مثال: صديقة، زوجتي، زميل عمل..."
                                   class="input-field text-sm">
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label class="block text-xs font-semibold text-gray-700">نص الرسالة الشخصية</label>
                            <span class="text-[11px] text-gray-400" x-text="message.length + ' / 500 حرف'"></span>
                        </div>
                        <textarea x-model="message"
                                  maxlength="500"
                                  rows="4"
                                  placeholder="اكتب هنا كلماتك الصادقة ومشاعرك الدافئة، وسنقوم بكتابتها بخط أنيق داخل البطاقة..."
                                  class="input-field text-sm"></textarea>
                    </div>

                    {{-- Sample message templates --}}
                    <div>
                        <span class="text-xs font-medium text-gray-500 mb-2 block">أفكار مقترحة لرسائل سريعة:</span>
                        <div class="flex flex-wrap gap-2">
                            <button type="button"
                                    @click="message = 'كل عام وأنت بألف خير وسعادة، أتمنى لك عاماً مليئاً بالنجاح والتألق ❤️'"
                                    class="text-xs bg-gray-100 hover:bg-brand-50 hover:text-brand-600 rounded-lg px-2.5 py-1.5 text-gray-600 transition-colors">
                                🎉 عيد ميلاد سعيد
                            </button>
                            <button type="button"
                                    @click="message = 'ألف مبروك التخرج والنجاح المستحق، فخورون بك دائماً وبإنجازك الرائع 🎓'"
                                    class="text-xs bg-gray-100 hover:bg-brand-50 hover:text-brand-600 rounded-lg px-2.5 py-1.5 text-gray-600 transition-colors">
                                🎓 مبروك التخرج
                            </button>
                            <button type="button"
                                    @click="message = 'شكراً لوجودك الدائم ولأثرك الجميل في حياتي، هذه الهدية البسيطة تعبير عن امتناني 🌸'"
                                    class="text-xs bg-gray-100 hover:bg-brand-50 hover:text-brand-600 rounded-lg px-2.5 py-1.5 text-gray-600 transition-colors">
                                🌸 شكر وامتنان
                            </button>
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex items-center justify-between border-t border-gray-100 pt-5">
                    <button type="button" @click="step = 2" class="btn-secondary text-sm">
                        <span>→ السابق: المنتجات</span>
                    </button>
                    <button type="button" @click="step = 4" class="btn-primary text-sm">
                        <span>التالي: معاينة الصندوق</span>
                        <span>←</span>
                    </button>
                </div>
            </div>

            {{-- STEP 4: Final Preview & Review --}}
            <div x-show="step === 4" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="card p-6">
                <div class="border-b border-gray-100 pb-4 mb-6">
                    <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                        <span>✨</span> الخطوة 4: مراجعة صندوقك المخصص
                    </h2>
                    <p class="text-xs text-gray-500 mt-1">تأكد من جميع التفاصيل قبل إضافة الصندوق إلى السلة</p>
                </div>

                {{-- Box Overview Card --}}
                <div class="bg-brand-50/50 border border-brand-200 rounded-2xl p-5 mb-6">
                    <div class="flex items-start justify-between gap-4 pb-4 border-b border-brand-100">
                        <div>
                            <span class="text-xs font-semibold text-brand-600">نوع الصندوق</span>
                            <h3 class="text-base font-bold text-gray-900" x-text="packagingName"></h3>
                            <p class="text-xs text-gray-500" x-show="occasion" x-text="'المناسبة: ' + occasion"></p>
                        </div>
                        <span class="badge-price text-xs" x-text="packagingPrice > 0 ? packagingPrice + ' ج.م' : 'مجاني'"></span>
                    </div>

                    {{-- Products List inside box --}}
                    <div class="py-4 border-b border-brand-100">
                        <span class="text-xs font-semibold text-brand-600 block mb-3">المنتجات داخل الصندوق (<span x-text="totalSelectedItemsCount"></span>)</span>
                        <div class="space-y-2">
                            <template x-for="item in selectedProducts" :key="item.product_id">
                                <div class="flex items-center justify-between text-xs py-1.5 px-3 bg-white rounded-xl border border-brand-100">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-8 h-8 rounded-lg bg-gray-100 overflow-hidden flex items-center justify-center shrink-0">
                                            <template x-if="item.image">
                                                <img :src="typeof formatImageUrl === 'function' ? formatImageUrl(item.image) : (item.image.startsWith('/storage') || item.image.startsWith('http') ? item.image : '/storage/' + item.image)"
                                                     class="w-full h-full object-cover">
                                            </template>
                                            <template x-if="!item.image">
                                                <span>🎁</span>
                                            </template>
                                        </div>
                                        <div>
                                            <span class="font-bold text-gray-800" x-text="item.name"></span>
                                            <span class="text-gray-400 mr-2" x-text="'× ' + item.quantity"></span>
                                        </div>
                                    </div>
                                    <span class="font-bold text-gray-900" x-text="(item.price * item.quantity).toFixed(2) + ' ج.م'"></span>
                                </div>
                            </template>
                        </div>
                    </div>

                    {{-- Card Message Preview --}}
                    <div class="pt-4" x-show="message || recipientName">
                        <span class="text-xs font-semibold text-brand-600 block mb-2">بطاقة الإهداء</span>
                        <div class="bg-white rounded-xl p-4 border border-brand-200 text-xs space-y-1 relative">
                            <div class="text-gray-400 text-lg absolute top-2 left-2">💌</div>
                            <div x-show="recipientName" class="font-bold text-brand-700" x-text="'إلى: ' + recipientName"></div>
                            <p class="text-gray-700 italic leading-relaxed whitespace-pre-line" x-text="message || 'بدون رسالة'"></p>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-4 border-t border-gray-100">
                    <button type="button" @click="step = 3" class="btn-secondary text-sm w-full sm:w-auto">
                        <span>→ تعديل الرسالة</span>
                    </button>
                    <button type="button"
                            @click="addToCartAndRedirect()"
                            class="btn-primary text-base py-3 px-8 w-full sm:w-auto justify-center shadow-lg">
                        <span>🛒 أضف الصندوق المخصص إلى السلة</span>
                        <span x-text="'(' + totalAmount.toFixed(2) + ' ج.م)'"></span>
                    </button>
                </div>
            </div>

        </div>

        {{-- Right Col: Live Summary Sidebar --}}
        <div class="card p-6 sticky top-24 space-y-5">
            <h3 class="font-bold text-gray-900 text-base flex items-center justify-between border-b border-gray-100 pb-3">
                <span>ملخص الصندوق</span>
                <span class="text-xs text-brand-600 bg-brand-50 px-2.5 py-1 rounded-full font-semibold"
                      x-text="'خطوة ' + step + ' من 4'"></span>
            </h3>

            {{-- Selected Packaging Preview --}}
            <div class="text-xs">
                <span class="text-gray-500 block mb-1">العلبة المختارة:</span>
                <div class="flex items-center justify-between font-bold text-gray-800 bg-gray-50 p-2.5 rounded-xl border border-gray-200">
                    <div class="flex items-center gap-2">
                        <span>📦</span>
                        <span x-text="packagingName || 'لم يتم الاختيار بعد'"></span>
                    </div>
                    <span class="text-brand-600" x-text="packagingPrice > 0 ? packagingPrice + ' ج.م' : (packagingId ? 'مجاني' : '-')"></span>
                </div>
            </div>

            {{-- Products in box counter --}}
            <div class="text-xs">
                <div class="flex items-center justify-between mb-1.5">
                    <span class="text-gray-500">محتويات الصندوق:</span>
                    <span class="font-bold text-gray-800" x-text="totalSelectedItemsCount + ' عناصر'"></span>
                </div>

                <div x-show="selectedProducts.length === 0" class="text-gray-400 italic text-center py-4 bg-gray-50 rounded-xl border border-dashed border-gray-200">
                    لم تختر أي منتجات بعد
                </div>

                <div x-show="selectedProducts.length > 0" class="space-y-1.5 max-h-48 overflow-y-auto pr-1">
                    <template x-for="item in selectedProducts" :key="item.product_id">
                        <div class="flex items-center justify-between py-1 px-2 rounded-lg bg-gray-50 text-[11px]">
                            <span class="font-medium text-gray-700 truncate max-w-[120px]" x-text="item.name"></span>
                            <div class="flex items-center gap-2">
                                <span class="text-gray-400" x-text="'×' + item.quantity"></span>
                                <span class="font-bold text-gray-900" x-text="(item.price * item.quantity).toFixed(2) + ' ج.م'"></span>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            {{-- Price Breakdown --}}
            <div class="border-t border-gray-100 pt-4 space-y-2 text-xs">
                <div class="flex justify-between text-gray-600">
                    <span>مجموع المنتجات:</span>
                    <span class="font-bold" x-text="productsSubtotal.toFixed(2) + ' ج.م'"></span>
                </div>
                <div class="flex justify-between text-gray-600">
                    <span>تكلفة التغليف والعلبة:</span>
                    <span class="font-bold" x-text="packagingPrice.toFixed(2) + ' ج.م'"></span>
                </div>
                <div class="flex justify-between text-gray-600">
                    <span>بطاقة الإهداء والطباعة:</span>
                    <span class="font-bold text-green-600">مجاناً</span>
                </div>
                <div class="border-t border-dashed border-gray-200 pt-3 flex justify-between items-center text-sm font-extrabold text-gray-900">
                    <span>إجمالي الصندوق:</span>
                    <span class="text-lg text-brand-600" x-text="totalAmount.toFixed(2) + ' ج.م'"></span>
                </div>
            </div>

            {{-- Quick action in sidebar --}}
            <div class="pt-2">
                <template x-if="step < 4">
                    <button type="button"
                            @click="goToNextStep()"
                            :disabled="!canProceedToNext()"
                            class="w-full btn-primary justify-center text-sm py-2.5"
                            :class="{'opacity-50 cursor-not-allowed': !canProceedToNext()}">
                        <span>متابعة الخطوة التالية</span>
                        <span>←</span>
                    </button>
                </template>
                <template x-if="step === 4">
                    <button type="button"
                            @click="addToCartAndRedirect()"
                            class="w-full btn-primary justify-center text-sm py-2.5">
                        <span>🛒 أضف للسلة الآن</span>
                    </button>
                </template>
            </div>

            <div class="text-[11px] text-gray-400 text-center leading-relaxed">
                💡 التوصيل وتأكيد الطلب يتم مباشرة عبر واتساب مع فريق خدمة العملاء.
            </div>
        </div>

    </div>
</div>

<script>
function customBoxBuilder() {
    return {
        step: 1,
        steps: [
            { id: 1, title: 'العلبة والتغليف' },
            { id: 2, title: 'المحتويات' },
            { id: 3, title: 'بطاقة الإهداء' },
            { id: 4, title: 'المعاينة' },
        ],

        // Step 1 data
        packagingId: {{ $packagingOptions->first()->id ?? 'null' }},
        packagingName: '{{ addslashes($packagingOptions->first()->name ?? "صندوق قياسي") }}',
        packagingPrice: {{ (float) ($packagingOptions->first()->price ?? 0) }},
        occasion: '',

        // Step 2 data
        availableProducts: [],
        loadingProducts: false,
        selectedCategory: '',
        searchQuery: '',
        pagination: { current_page: 1, last_page: 1 },
        selectedProducts: [], // [{ product_id, name, price, image, quantity }]

        // Step 3 data
        recipientName: '',
        recipientType: '',
        message: '',

        init() {
            this.fetchProducts(1);
        },

        selectPackaging(id, name, price) {
            this.packagingId = id;
            this.packagingName = name;
            this.packagingPrice = parseFloat(price);
        },

        async fetchProducts(page = 1) {
            this.loadingProducts = true;
            try {
                let url = `/api/builder/products?page=${page}`;
                if (this.selectedCategory) url += `&category_id=${this.selectedCategory}`;
                if (this.searchQuery) url += `&q=${encodeURIComponent(this.searchQuery)}`;

                const res = await fetch(url);
                const data = await res.json();
                this.availableProducts = data.data || [];
                this.pagination = {
                    current_page: data.current_page || 1,
                    last_page: data.last_page || 1,
                };
            } catch (e) {
                console.error('Error fetching products:', e);
            } finally {
                this.loadingProducts = false;
            }
        },

        getProductQty(productId) {
            const item = this.selectedProducts.find(p => p.product_id === productId);
            return item ? item.quantity : 0;
        },

        addProduct(product) {
            const existing = this.selectedProducts.find(p => p.product_id === product.id);
            if (existing) {
                existing.quantity++;
            } else {
                this.selectedProducts.push({
                    product_id: product.id,
                    name: product.name,
                    price: parseFloat(product.price),
                    image: product.image,
                    quantity: 1,
                });
            }
        },

        removeProduct(productId) {
            const index = this.selectedProducts.findIndex(p => p.product_id === productId);
            if (index >= 0) {
                if (this.selectedProducts[index].quantity > 1) {
                    this.selectedProducts[index].quantity--;
                } else {
                    this.selectedProducts.splice(index, 1);
                }
            }
        },

        get totalSelectedItemsCount() {
            return this.selectedProducts.reduce((sum, p) => sum + p.quantity, 0);
        },

        get productsSubtotal() {
            return this.selectedProducts.reduce((sum, p) => sum + (p.price * p.quantity), 0);
        },

        get totalAmount() {
            return this.productsSubtotal + this.packagingPrice;
        },

        canGoToStep(targetStep) {
            if (targetStep === 1) return true;
            if (targetStep === 2) return !!this.packagingId;
            if (targetStep === 3) return !!this.packagingId && this.selectedProducts.length > 0;
            if (targetStep === 4) return !!this.packagingId && this.selectedProducts.length > 0;
            return false;
        },

        canProceedToNext() {
            if (this.step === 1) return !!this.packagingId;
            if (this.step === 2) return this.selectedProducts.length > 0;
            if (this.step === 3) return true;
            return true;
        },

        goToNextStep() {
            if (this.canProceedToNext() && this.step < 4) {
                this.step++;
            }
        },

        addToCartAndRedirect() {
            if (!this.packagingId || this.selectedProducts.length === 0) return;

            const customBox = {
                packaging_option_id: this.packagingId,
                packaging_name: this.packagingName,
                packaging_cost: this.packagingPrice,
                occasion: this.occasion,
                recipient_type: this.recipientType,
                personal_message: this.message,
                products: this.selectedProducts.map(p => ({
                    product_id: p.product_id,
                    name: p.name,
                    quantity: p.quantity,
                    price: p.price,
                    image: p.image,
                })),
                unit_price: this.totalAmount,
                price: this.totalAmount,
            };

            Alpine.store('cart').addCustomBox(customBox);
            window.location.href = "{{ route('cart') }}";
        },
    };
}
</script>
@endsection
