<?php

namespace Database\Seeders;

use App\Enums\InquiryStatus;
use App\Enums\ItemType;
use App\Enums\OrderStatus;
use App\Enums\OrderType;
use App\Enums\ReviewStatus;
use App\Models\Category;
use App\Models\CompanyInquiry;
use App\Models\GiftBox;
use App\Models\GiftBoxItem;
use App\Models\Occasion;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PackagingOption;
use App\Models\Product;
use App\Models\Review;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Admin & Test Users
        User::updateOrCreate(
            ['email' => 'admin@giftly.eg'],
            [
                'name' => 'مدير النظام (جيفتلي)',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'مستخدم تجريبي',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // 2. Settings
        $settings = [
            'store_name' => 'جيفتلي - متجر الهدايا الفاخرة',
            'whatsapp_number' => '201112126939',
            'store_phone' => '+20 11 1212 6939',
            'store_email' => 'info@giftly.eg',
            'store_currency' => 'ج.م',
            'delivery_note' => 'التوصيل متاح لجميع محافظات جمهورية مصر العربية خلال 24 - 48 ساعة.',
        ];

        foreach ($settings as $key => $val) {
            Setting::updateOrCreate(['key' => $key], ['value' => $val]);
        }

        // 3. Occasions (المناسبات)
        // 3. Occasions (المناسبات)
        $occasionsData = [
            ['name' => 'أعياد ميلاد', 'slug' => 'birthday', 'description' => 'هدايا مميزة للاحتفال بيوم الميلاد وصنع ذكريات سعيدة', 'sort_order' => 1],
            ['name' => 'زفاف وخطوبة', 'slug' => 'wedding-engagement', 'description' => 'هدايا فاخرة ومباركات للعروسين بأجمل اللحظات', 'sort_order' => 2],
            ['name' => 'تخرج ونجاح', 'slug' => 'graduation', 'description' => 'مكافأة الإنجاز وفرحة التخرج والتميز الأكاديمي', 'sort_order' => 3],
            ['name' => 'حب ورومانسية', 'slug' => 'love-romance', 'description' => 'تعبيرات حب دافئة للمناسبات الخاصة والذكرى السنوية', 'sort_order' => 4],
            ['name' => 'مولود جديد', 'slug' => 'new-baby', 'description' => 'تهنئة بقدوم الملاك الصغير وهدايا لطيفة للأم والمولود', 'sort_order' => 5],
            ['name' => 'شكر وامتنان', 'slug' => 'thank-you', 'description' => 'رسائل شكر وتقدير راقية لمن لهم بصمة جميلة في حياتك', 'sort_order' => 6],
            ['name' => 'سلامة وشفاء', 'slug' => 'get-well', 'description' => 'تمنيات بالشفاء العاجل وباقات ترفع المعنويات وتبث الأمل', 'sort_order' => 7],
            ['name' => 'ترقية وتكريم', 'slug' => 'promotion', 'description' => 'هدايا تقدير للزملاء والمدراء بمناسبة النجاح المهني', 'sort_order' => 8],
        ];

        $occasions = collect();
        foreach ($occasionsData as $occ) {
            $occasions->push(Occasion::updateOrCreate(
                ['slug' => $occ['slug']],
                [
                    'name' => $occ['name'],
                    'description' => $occ['description'],
                    'sort_order' => $occ['sort_order'],
                    'is_active' => true,
                ]
            ));
        }

        // 4. Categories (الأقسام)
        $categoriesData = [
            ['name' => 'زهور وورود طبيعية', 'slug' => 'flowers', 'description' => 'ورود طبيعية فريش بتنسيقات خلابة تناسب كل مناسبة', 'sort_order' => 1],
            ['name' => 'شوكولاتة وحلويات فاخرة', 'slug' => 'chocolates', 'description' => 'شوكولاتة بلجيكية وسويسرية وترافل غني بنكهات استثنائية', 'sort_order' => 2],
            ['name' => 'شموع وفواحات عطرية', 'slug' => 'candles', 'description' => 'شموع صويا طبيعية وفواحات منزلية بعبير مهدئ وفاخر', 'sort_order' => 3],
            ['name' => 'مجات وأكواب حرارية', 'slug' => 'mugs', 'description' => 'مجات سيراميك رخامية وأكواب حافظة للحرارة بتصاميم راقية', 'sort_order' => 4],
            ['name' => 'دباديب وألعاب لطيفة', 'slug' => 'plushies', 'description' => 'ألعاب قطنية ودباديب تيدي فائقة النعومة للجميع', 'sort_order' => 5],
            ['name' => 'بطاقات إهداء فاخرة', 'slug' => 'cards', 'description' => 'بطاقات مذهبة بعبارات حب وتهنئة مطبوعة بجودة عالية', 'sort_order' => 6],
            ['name' => 'عطور وبخور ملكي', 'slug' => 'perfumes', 'description' => 'نفحات شرقية ساحرة ومباخر كريستال أنيقة', 'sort_order' => 7],
            ['name' => 'دفاتر وإكسسوارات راقية', 'slug' => 'accessories', 'description' => 'دفاتر جلدية، ساعات يد، وأقلام حبر فخمة', 'sort_order' => 8],
        ];

        $categories = collect();
        foreach ($categoriesData as $cat) {
            $categories->push(Category::updateOrCreate(
                ['slug' => $cat['slug']],
                [
                    'name' => $cat['name'],
                    'description' => $cat['description'],
                    'sort_order' => $cat['sort_order'],
                    'is_active' => true,
                ]
            ));
        }

        // 5. Packaging Options (خيارات التغليف)
        $packagingsData = [
            [
                'name' => 'صندوق جيفتلي الكلاسيكي مع شريط ستان',
                'description' => 'صندوق كرتوني متين باللون الوردي الناعم مع بطانة حماية وشريط ستان أنيق.',
                'price' => 0.00,
                'sort_order' => 1,
            ],
            [
                'name' => 'صندوق مغناطيسي فاخر (لون بلش بينك)',
                'description' => 'صندوق هدايا مقوى بغطاء مغناطيسي ولمسة مخملية فاخرة تدوم طويلاً.',
                'price' => 45.00,
                'sort_order' => 2,
            ],
            [
                'name' => 'صندوق خشبي محفور يدوياً بالليزر',
                'description' => 'خشب طبيعي معتق ومحفور بنقوش عربية راقية، مثالي للهدايا القيمة والتذكارية.',
                'price' => 85.00,
                'sort_order' => 3,
            ],
            [
                'name' => 'بوكس أكريليك شفاف مودرن',
                'description' => 'تصميم عصري شفاف مع تنسيق ورود داخلية وشريط حريري فاخر.',
                'price' => 65.00,
                'sort_order' => 4,
            ],
            [
                'name' => 'سلة خوص ريفية مزينة بزهور مجففة',
                'description' => 'سلة قش طبيعية منسوجة يدوياً ومزينة بالزهور المجففة ولمسات الريف الأوروبي.',
                'price' => 95.00,
                'sort_order' => 5,
            ],
        ];

        $packagingOptions = collect();
        foreach ($packagingsData as $pkg) {
            $packagingOptions->push(PackagingOption::updateOrCreate(
                ['name' => $pkg['name']],
                [
                    'description' => $pkg['description'],
                    'price' => $pkg['price'],
                    'sort_order' => $pkg['sort_order'],
                    'is_active' => true,
                ]
            ));
        }

        // 6. Products (المنتجات)
        $catMap = $categories->keyBy('slug');
        $occMap = $occasions->keyBy('slug');

        $productsData = [
            // Flowers
            [
                'name' => 'باقة جوري أحمر ملكي (12 وردة)',
                'slug' => 'royal-red-roses-12',
                'category_slug' => 'flowers',
                'price' => 320.00,
                'cost_price' => 180.00,
                'stock_quantity' => 25,
                'is_featured' => true,
                'description' => 'ورود جوري أحمر هولندي طبيعي منتقاة بعناية فائقة مع لمسات أوراق الكينا الخضراء.',
                'occasions' => ['love-romance', 'wedding-engagement', 'birthday'],
            ],
            [
                'name' => 'باقة توليب وردي رقيقة',
                'slug' => 'soft-pink-tulips',
                'category_slug' => 'flowers',
                'price' => 280.00,
                'cost_price' => 150.00,
                'stock_quantity' => 18,
                'is_featured' => true,
                'description' => 'زهور التوليب الوردية الطبيعية تعبر عن الرقة والامتنان والجمال الهادئ.',
                'occasions' => ['birthday', 'thank-you', 'new-baby'],
            ],
            [
                'name' => 'فازة زهور بيضاء وبيبي أوركيد',
                'slug' => 'white-blooms-orchid-vase',
                'category_slug' => 'flowers',
                'price' => 390.00,
                'cost_price' => 220.00,
                'stock_quantity' => 12,
                'is_featured' => false,
                'description' => 'تنسيق أنيق من زهور الليليوم والأوركيد الأبيض داخل فازة زجاجية أسطوانية.',
                'occasions' => ['wedding-engagement', 'get-well', 'promotion'],
            ],

            // Chocolates
            [
                'name' => 'علبة شوكولاتة بلجيكية فاخرة (16 قطعة)',
                'slug' => 'belgian-luxury-chocolates-16',
                'category_slug' => 'chocolates',
                'price' => 240.00,
                'cost_price' => 130.00,
                'stock_quantity' => 40,
                'is_featured' => true,
                'description' => 'تشكيلة ترافل وشوكولاتة بلجيكية بحشوات الكراميل المملح، البندق المحمص، واللوتس.',
                'occasions' => ['birthday', 'love-romance', 'graduation', 'thank-you'],
            ],
            [
                'name' => 'صندوق ترافل شوكولاتة داكنة بالبندق',
                'slug' => 'dark-hazelnut-truffles',
                'category_slug' => 'chocolates',
                'price' => 190.00,
                'cost_price' => 100.00,
                'stock_quantity' => 30,
                'is_featured' => false,
                'description' => 'شوكولاتة داكنة غنية 70% كاكاو مع قطع البندق المحمص المقرمش.',
                'occasions' => ['birthday', 'promotion'],
            ],
            [
                'name' => 'برطمان شوكولاتة كوكيز وفراولة',
                'slug' => 'cookies-strawberry-jar',
                'category_slug' => 'chocolates',
                'price' => 150.00,
                'cost_price' => 75.00,
                'stock_quantity' => 35,
                'is_featured' => false,
                'description' => 'قطع كوكيز مغطاة بالشوكولاتة البيضاء مع رقائق الفراولة المجففة الطبيعية.',
                'occasions' => ['birthday', 'new-baby'],
            ],

            // Candles
            [
                'name' => 'شمعة صويا عطرية برائحة الفانيليا واللافندر',
                'slug' => 'french-lavender-soy-candle',
                'category_slug' => 'candles',
                'price' => 160.00,
                'cost_price' => 80.00,
                'stock_quantity' => 30,
                'is_featured' => true,
                'description' => 'شمع الصويا العضوي 100% مع فتيل قطني نقي، يمنح أجواء من الاسترخاء والهدوء تدوم 40 ساعة.',
                'occasions' => ['love-romance', 'get-well', 'birthday'],
            ],
            [
                'name' => 'فواحة أعواد خشبية برائحة العود الملكي والمسك',
                'slug' => 'royal-oud-reed-diffuser',
                'category_slug' => 'candles',
                'price' => 210.00,
                'cost_price' => 110.00,
                'stock_quantity' => 22,
                'is_featured' => false,
                'description' => 'فواحة منزلية تدوم طويلاً بعبير العود الشرقي الفاخر ونفحات المسك الأبيض.',
                'occasions' => ['promotion', 'wedding-engagement', 'thank-you'],
            ],
            [
                'name' => 'شمعة معطرة برائحة الورد والكرز الياباني',
                'slug' => 'cherry-blossom-candle',
                'category_slug' => 'candles',
                'price' => 140.00,
                'cost_price' => 70.00,
                'stock_quantity' => 28,
                'is_featured' => false,
                'description' => 'عبير ناعم ومنعش من أزهار الكرز وزهر البرتقال داخل وعاء زجاجي مصنفر بلون وردي.',
                'occasions' => ['birthday', 'love-romance'],
            ],

            // Mugs
            [
                'name' => 'مج سيراميك رخامي وردي بحواف ذهبية',
                'slug' => 'pink-marble-ceramic-mug',
                'category_slug' => 'mugs',
                'price' => 125.00,
                'cost_price' => 60.00,
                'stock_quantity' => 50,
                'is_featured' => true,
                'description' => 'مج سيراميك رخامي يدوي الصنع مع مقبض وحافة مطلية بالذهب عيار 24 وملعقة ذهبية.',
                'occasions' => ['birthday', 'graduation', 'thank-you'],
            ],
            [
                'name' => 'كوب حراري حافظ للحرارة استانلس ستيل',
                'slug' => 'thermal-travel-tumbler',
                'category_slug' => 'mugs',
                'price' => 220.00,
                'cost_price' => 115.00,
                'stock_quantity' => 35,
                'is_featured' => false,
                'description' => 'يحفظ الحرارة حتى 8 ساعات والبرودة حتى 12 ساعة، بسعة 500 مل وتصميم عصري أنيق.',
                'occasions' => ['graduation', 'promotion'],
            ],
            [
                'name' => 'طقم مجين بورسلين "King & Queen"',
                'slug' => 'king-queen-mugs-set',
                'category_slug' => 'mugs',
                'price' => 250.00,
                'cost_price' => 120.00,
                'stock_quantity' => 20,
                'is_featured' => false,
                'description' => 'طقم كوبين مميزين للمتزوجين والمخطوبين مع أغطية خشبية أنيقة وملاعق مذهبة.',
                'occasions' => ['wedding-engagement', 'love-romance'],
            ],

            // Plushies
            [
                'name' => 'دبدوب تيدي بير بني كلاسيكي (30 سم)',
                'slug' => 'classic-brown-teddy-bear',
                'category_slug' => 'plushies',
                'price' => 180.00,
                'cost_price' => 90.00,
                'stock_quantity' => 30,
                'is_featured' => true,
                'description' => 'دبدوب ناعم جداً ومحبوب، خامات قطنية آمنة للأطفال ومناسب لجميع المناسبات.',
                'occasions' => ['birthday', 'love-romance', 'new-baby'],
            ],
            [
                'name' => 'دبدوب وردي يحمل قلباً مطرزاً',
                'slug' => 'pink-teddy-heart',
                'category_slug' => 'plushies',
                'price' => 195.00,
                'cost_price' => 95.00,
                'stock_quantity' => 25,
                'is_featured' => false,
                'description' => 'دبدوب أنيق باللون الوردي يحمل قلباً ناعماً مطرزاً بعبارة محبة لطيفة.',
                'occasions' => ['love-romance', 'birthday'],
            ],

            // Cards
            [
                'name' => 'بطاقة إهداء مذهبة "كل عام وأنت بخير"',
                'slug' => 'happy-birthday-gold-foil-card',
                'category_slug' => 'cards',
                'price' => 35.00,
                'cost_price' => 10.00,
                'stock_quantity' => 100,
                'is_featured' => false,
                'description' => 'ورق مقوى 350 جرام مع خط عربي ذهبي بارز ومغلف شمعي أنيق.',
                'occasions' => ['birthday'],
            ],
            [
                'name' => 'بطاقة تهنئة تخرج مرصعة بالفويل الذهبي',
                'slug' => 'graduation-congrats-card',
                'category_slug' => 'cards',
                'price' => 35.00,
                'cost_price' => 10.00,
                'stock_quantity' => 80,
                'is_featured' => false,
                'description' => 'بطاقة تخرج فخمة بتصميم قبعة تخرج ونقوش مذهبة.',
                'occasions' => ['graduation'],
            ],

            // Perfumes & Aromas
            [
                'name' => 'عطر شرقي فاخر (ميني 50 مل)',
                'slug' => 'oriental-luxury-perfume-50ml',
                'category_slug' => 'perfumes',
                'price' => 350.00,
                'cost_price' => 190.00,
                'stock_quantity' => 20,
                'is_featured' => true,
                'description' => 'مزيج ساحر من خشب الصندل والعنبر والياسمين الدمشقي في زجاجة كريستالية رائعة.',
                'occasions' => ['wedding-engagement', 'promotion', 'love-romance'],
            ],
            [
                'name' => 'مبخرة كريستال عصرية مع بخور مروكي',
                'slug' => 'crystal-burner-moroki-bukhoor',
                'category_slug' => 'perfumes',
                'price' => 280.00,
                'cost_price' => 140.00,
                'stock_quantity' => 25,
                'is_featured' => false,
                'description' => 'مبخرة زجاجية ذهبية فاخرة مع عبوة بخور مروكي طبيعي فاخر.',
                'occasions' => ['wedding-engagement', 'promotion', 'thank-you'],
            ],

            // Accessories
            [
                'name' => 'دفتر ملاحظات جلدي فاخر مع قلم حبر معدني',
                'slug' => 'leather-journal-luxury-pen',
                'category_slug' => 'accessories',
                'price' => 210.00,
                'cost_price' => 100.00,
                'stock_quantity' => 30,
                'is_featured' => false,
                'description' => 'غلاف جلدي راقي مع ورق مسطر عالي الجودة وقلم حبر جاف ذهبي فخم.',
                'occasions' => ['graduation', 'promotion', 'thank-you'],
            ],
            [
                'name' => 'ساعة يد كلاسيكية بلون ذهبي وردي',
                'slug' => 'rose-gold-classic-watch',
                'category_slug' => 'accessories',
                'price' => 450.00,
                'cost_price' => 250.00,
                'stock_quantity' => 15,
                'is_featured' => true,
                'description' => 'ساعة أنيقة ضد رذاذ الماء بسوار ستانلس ستيل وميناء صدف أنيق.',
                'occasions' => ['birthday', 'graduation', 'wedding-engagement'],
            ],
        ];

        $createdProducts = collect();
        foreach ($productsData as $pData) {
            $cat = $catMap->get($pData['category_slug']);
            $product = Product::updateOrCreate(
                ['slug' => $pData['slug']],
                [
                    'category_id' => $cat?->id,
                    'name' => $pData['name'],
                    'price' => $pData['price'],
                    'stock_quantity' => $pData['stock_quantity'],
                    'is_featured' => $pData['is_featured'],
                    'is_active' => true,
                    'description' => $pData['description'],
                ]
            );

            // Sync occasions
            $occIds = [];
            foreach ($pData['occasions'] as $oSlug) {
                if ($occ = $occMap->get($oSlug)) {
                    $occIds[] = $occ->id;
                }
            }
            $product->occasions()->sync($occIds);
            $createdProducts->push($product);
        }

        // 7. Ready-made Gift Boxes (صناديق الهدايا الجاهزة)
        $boxesData = [
            [
                'name' => 'صندوق لحظات رومانسية',
                'slug' => 'romantic-moments-box',
                'price' => 790.00,
                'is_featured' => true,
                'description' => 'مجموعة غامرة بالدفء والمشاعر: باقة جوري أحمر ملكي، شوكولاتة بلجيكية فاخرة، شمعة لافندر مهدئة، وبطاقة إهداء مذهبة.',
                'occasions' => ['love-romance', 'wedding-engagement'],
                'products' => [
                    'royal-red-roses-12' => 1,
                    'belgian-luxury-chocolates-16' => 1,
                    'french-lavender-soy-candle' => 1,
                ],
            ],
            [
                'name' => 'صندوق عيد ميلاد مبهج',
                'slug' => 'joyful-birthday-box',
                'price' => 640.00,
                'is_featured' => true,
                'description' => 'كل ما يلزم لصنع ابتسامة في يوم ميلادهم: دبدوب تيدي ناعم، مج سيراميك رخامي، علبة ترافل شوكولاتة، وبطاقة تهنئة مذهبة.',
                'occasions' => ['birthday'],
                'products' => [
                    'classic-brown-teddy-bear' => 1,
                    'pink-marble-ceramic-mug' => 1,
                    'dark-hazelnut-truffles' => 1,
                    'happy-birthday-gold-foil-card' => 1,
                ],
            ],
            [
                'name' => 'صندوق تهاني التخرج والتميز',
                'slug' => 'graduation-excellence-box',
                'price' => 780.00,
                'is_featured' => true,
                'description' => 'هدية تتناسب مع فرحة الإنجاز: كوب حراري ستانلس ستيل، دفتر ملاحظات جلدي فاخر مع قلم، شوكولاتة بلجيكية، وبطاقة تخرج مذهبة.',
                'occasions' => ['graduation', 'promotion'],
                'products' => [
                    'thermal-travel-tumbler' => 1,
                    'leather-journal-luxury-pen' => 1,
                    'belgian-luxury-chocolates-16' => 1,
                    'graduation-congrats-card' => 1,
                ],
            ],
            [
                'name' => 'صندوق السكينة والاسترخاء',
                'slug' => 'peace-relaxation-box',
                'price' => 690.00,
                'is_featured' => true,
                'description' => 'دعوة للاسترخاء والهدوء: فواحة عود ملكي، شمعة فانيليا، مج رخامي وردي، وشوكولاتة سويسرية فاخرة.',
                'occasions' => ['thank-you', 'get-well', 'birthday'],
                'products' => [
                    'royal-oud-reed-diffuser' => 1,
                    'french-lavender-soy-candle' => 1,
                    'pink-marble-ceramic-mug' => 1,
                ],
            ],
            [
                'name' => 'صندوق الفخامة الملكية',
                'slug' => 'royal-luxury-gift-box',
                'price' => 1150.00,
                'is_featured' => true,
                'description' => 'هدية راقية للشخصيات المميزة: ساعة يد كلاسيكية روز جولد، عطر شرقي 50 مل، مبخرة كريستال، وشوكولاتة بلجيكية فاخرة.',
                'occasions' => ['wedding-engagement', 'promotion', 'birthday'],
                'products' => [
                    'rose-gold-classic-watch' => 1,
                    'oriental-luxury-perfume-50ml' => 1,
                    'crystal-burner-moroki-bukhoor' => 1,
                    'belgian-luxury-chocolates-16' => 1,
                ],
            ],
            [
                'name' => 'صندوق مرحباً بالصغير (New Baby)',
                'slug' => 'welcome-little-one-box',
                'price' => 590.00,
                'is_featured' => false,
                'description' => 'أجمل هدية للاحتفال بقدوم المولود الجديد: دبدوب لطيف فائق النعومة، شوكولاتة كوكيز، شمعة كرز، وبطاقة إهداء مبهجة.',
                'occasions' => ['new-baby'],
                'products' => [
                    'classic-brown-teddy-bear' => 1,
                    'cookies-strawberry-jar' => 1,
                    'cherry-blossom-candle' => 1,
                ],
            ],
            [
                'name' => 'صندوق شكر وتقدير راقي',
                'slug' => 'elegant-gratitude-box',
                'price' => 580.00,
                'is_featured' => false,
                'description' => 'عبر عن شكرك وامتنانك الصادق: مج سيراميك فاخر، علبة شوكولاتة بلجيكية، شمعة معطرة، وباقة توليب ناعمة.',
                'occasions' => ['thank-you', 'promotion'],
                'products' => [
                    'pink-marble-ceramic-mug' => 1,
                    'belgian-luxury-chocolates-16' => 1,
                    'soft-pink-tulips' => 1,
                ],
            ],
            [
                'name' => 'صندوق مبروك الخطوبة والزفاف',
                'slug' => 'wedding-congrats-luxury-box',
                'price' => 920.00,
                'is_featured' => true,
                'description' => 'مخصص لأجمل عروسين: طقم مجات King & Queen، فازة زهور بيضاء، عطر شرقي، وشوكولاتة فاخرة.',
                'occasions' => ['wedding-engagement'],
                'products' => [
                    'king-queen-mugs-set' => 1,
                    'white-blooms-orchid-vase' => 1,
                    'oriental-luxury-perfume-50ml' => 1,
                ],
            ],
        ];

        $prodMap = $createdProducts->keyBy('slug');
        $createdBoxes = collect();

        foreach ($boxesData as $bData) {
            $giftBox = GiftBox::updateOrCreate(
                ['slug' => $bData['slug']],
                [
                    'name' => $bData['name'],
                    'price' => $bData['price'],
                    'description' => $bData['description'],
                    'is_featured' => $bData['is_featured'],
                    'is_active' => true,
                    'sort_order' => 1,
                ]
            );

            // Sync occasions
            $occIds = [];
            foreach ($bData['occasions'] as $oSlug) {
                if ($occ = $occMap->get($oSlug)) {
                    $occIds[] = $occ->id;
                }
            }
            $giftBox->occasions()->sync($occIds);

            // Sync items in box
            GiftBoxItem::where('gift_box_id', $giftBox->id)->delete();
            foreach ($bData['products'] as $pSlug => $qty) {
                if ($prod = $prodMap->get($pSlug)) {
                    GiftBoxItem::create([
                        'gift_box_id' => $giftBox->id,
                        'product_id' => $prod->id,
                        'quantity' => $qty,
                    ]);
                }
            }

            $createdBoxes->push($giftBox);
        }

        // 8. Sample Orders for Testing (طلبات متنوعة لاختبار لوحة Filament)
        $sampleOrders = [
            [
                'customer_name' => 'سارة أحمد محمود',
                'customer_phone' => '01011223344',
                'customer_address' => 'القاهرة، مصر الجديدة، شارع الثورة، عمارة 15',
                'status' => OrderStatus::Pending,
                'order_type' => OrderType::Custom,
                'customer_notes' => 'يرجى كتابة بطاقة الإهداء بخط رقعة أنيق، والتوصيل بعد الساعة 6 مساءً.',
                'subtotal' => 645.00,
                'packaging_cost' => 45.00,
                'total' => 690.00,
                'items' => [
                    [
                        'item_type' => ItemType::CustomGiftBox,
                        'name_snapshot' => 'صندوق هدايا مخصص (عيد ميلاد)',
                        'quantity' => 1,
                        'unit_price' => 690.00,
                        'total_price' => 690.00,
                        'customization_data' => [
                            'packaging_name' => 'صندوق مغناطيسي فاخر (لون بلش بينك)',
                            'packaging_cost' => 45.00,
                            'occasion' => 'أعياد ميلاد',
                            'recipient_type' => 'صديقة',
                            'personal_message' => 'كل سنة وأنتِ طيبة يا سارة يا أجدع صاحبة في الدنيا! أتمنى لك سنة سعيدة ❤️',
                            'products' => [
                                ['name' => 'مج سيراميك رخامي وردي', 'quantity' => 1, 'line_total' => '125.00'],
                                ['name' => 'علبة شوكولاتة بلجيكية فاخرة', 'quantity' => 1, 'line_total' => '240.00'],
                                ['name' => 'دبدوب وردي يحمل قلباً', 'quantity' => 1, 'line_total' => '195.00'],
                                ['name' => 'بطاقة إهداء مذهبة', 'quantity' => 1, 'line_total' => '35.00'],
                            ],
                        ],
                    ],
                ],
            ],
            [
                'customer_name' => 'م / عمر خالد المنشاوي',
                'customer_phone' => '01122334455',
                'customer_address' => 'الجيزة، الشيخ زايد، كمبوند الياسمين، فيلا 22',
                'status' => OrderStatus::Confirmed,
                'order_type' => OrderType::ReadyMade,
                'customer_notes' => 'هدية لزوجتي بمناسبة ذكرى زواجنا، يرجى تغليف فاخر وسري.',
                'subtotal' => 790.00,
                'packaging_cost' => 0.00,
                'total' => 790.00,
                'items' => [
                    [
                        'item_type' => ItemType::ReadyMadeGiftBox,
                        'name_snapshot' => 'صندوق لحظات رومانسية',
                        'quantity' => 1,
                        'unit_price' => 790.00,
                        'total_price' => 790.00,
                        'gift_box_id' => $createdBoxes->first()?->id,
                        'customization_data' => null,
                    ],
                ],
            ],
            [
                'customer_name' => 'د / نورهان مصطفى',
                'customer_phone' => '01233445566',
                'customer_address' => 'الإسكندرية، سموحة، شارع فوزي معاذ',
                'status' => OrderStatus::Preparing,
                'order_type' => OrderType::ReadyMade,
                'customer_notes' => 'التوصيل يوم الخميس ظهراً ضروري.',
                'subtotal' => 780.00,
                'packaging_cost' => 0.00,
                'total' => 780.00,
                'items' => [
                    [
                        'item_type' => ItemType::ReadyMadeGiftBox,
                        'name_snapshot' => 'صندوق تهاني التخرج والتميز',
                        'quantity' => 1,
                        'unit_price' => 780.00,
                        'total_price' => 780.00,
                        'gift_box_id' => $createdBoxes->skip(2)->first()?->id,
                        'customization_data' => null,
                    ],
                ],
            ],
            [
                'customer_name' => 'كريم عصام الدين',
                'customer_phone' => '01544556677',
                'customer_address' => 'القاهرة، المعادي، دجلة، شارع 206',
                'status' => OrderStatus::Shipped,
                'order_type' => OrderType::Mixed,
                'customer_notes' => 'مستلم الهدية: منة إبراهيم - هاتفها: 01099887766',
                'subtotal' => 600.00,
                'packaging_cost' => 0.00,
                'total' => 600.00,
                'items' => [
                    [
                        'item_type' => ItemType::Product,
                        'name_snapshot' => 'باقة جوري أحمر ملكي (12 وردة)',
                        'quantity' => 1,
                        'unit_price' => 320.00,
                        'total_price' => 320.00,
                        'product_id' => $createdProducts->first()?->id,
                        'customization_data' => null,
                    ],
                    [
                        'item_type' => ItemType::Product,
                        'name_snapshot' => 'باقة توليب وردي رقيقة',
                        'quantity' => 1,
                        'unit_price' => 280.00,
                        'total_price' => 280.00,
                        'product_id' => $createdProducts->skip(1)->first()?->id,
                        'customization_data' => null,
                    ],
                ],
            ],
            [
                'customer_name' => 'مها عبد الرحمن',
                'customer_phone' => '01055667788',
                'customer_address' => 'القاهرة، التجمع الخامس، النرجس 3',
                'status' => OrderStatus::Completed,
                'order_type' => OrderType::ReadyMade,
                'customer_notes' => 'تم استلام الهدية بنجاح، شكراً لخدمتكم الراقية.',
                'subtotal' => 1150.00,
                'packaging_cost' => 0.00,
                'total' => 1150.00,
                'items' => [
                    [
                        'item_type' => ItemType::ReadyMadeGiftBox,
                        'name_snapshot' => 'صندوق الفخامة الملكية',
                        'quantity' => 1,
                        'unit_price' => 1150.00,
                        'total_price' => 1150.00,
                        'gift_box_id' => $createdBoxes->skip(4)->first()?->id,
                        'customization_data' => null,
                    ],
                ],
            ],
        ];

        foreach ($sampleOrders as $idx => $sOrder) {
            $order = Order::updateOrCreate(
                ['customer_phone' => $sOrder['customer_phone']],
                [
                    'order_number' => 'GFT-'.strtoupper(Str::random(8)),
                    'customer_name' => $sOrder['customer_name'],
                    'customer_address' => $sOrder['customer_address'],
                    'customer_notes' => $sOrder['customer_notes'],
                    'status' => $sOrder['status']->value,
                    'order_type' => $sOrder['order_type']->value,
                    'subtotal' => $sOrder['subtotal'],
                    'packaging_cost' => $sOrder['packaging_cost'],
                    'total' => $sOrder['total'],
                    'created_at' => now()->subDays(6 - $idx),
                ]
            );

            OrderItem::where('order_id', $order->id)->delete();
            foreach ($sOrder['items'] as $itemData) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'item_type' => $itemData['item_type']->value,
                    'product_id' => $itemData['product_id'] ?? null,
                    'gift_box_id' => $itemData['gift_box_id'] ?? null,
                    'name_snapshot' => $itemData['name_snapshot'],
                    'quantity' => $itemData['quantity'],
                    'unit_price' => $itemData['unit_price'],
                    'total_price' => $itemData['total_price'],
                    'customization_data' => $itemData['customization_data'] ?? null,
                ]);
            }
        }

        // 9. Customer Reviews (تقييمات العملاء)
        $reviewsData = [
            [
                'customer_name' => 'منى الشاذلي',
                'rating' => 5,
                'comment' => 'تجربة أكثر من رائعة! التغليف يفوق التوقعات والاهتمام بالتفاصيل مذهل، والشوكولاتة طازجة ولذيذة جداً.',
                'gift_box_id' => $createdBoxes->first()?->id,
                'status' => ReviewStatus::Approved->value,
            ],
            [
                'customer_name' => 'أحمد العوضي',
                'rating' => 5,
                'comment' => 'الطلب وصل في موعده تماماً والمفاجأة كانت أجمل مما تخيلت، خدمة عملاء واتساب محترمة ومتعاونة جداً.',
                'gift_box_id' => $createdBoxes->first()?->id,
                'status' => ReviewStatus::Approved->value,
            ],
            [
                'customer_name' => 'رانيا علواني',
                'rating' => 5,
                'comment' => 'شمعة اللافندر رائحتها هادئة وطبيعية جداً، جودة لا توصف وسأكرر التجربة بالتأكيد.',
                'product_id' => $createdProducts->firstWhere('slug', 'french-lavender-soy-candle')?->id,
                'status' => ReviewStatus::Approved->value,
            ],
            [
                'customer_name' => 'يوسف إبراهيم',
                'rating' => 5,
                'comment' => 'المج الرخامي تحفة فنية والحافة الذهبية فخمة جداً، شكراً جيفتلي!',
                'product_id' => $createdProducts->firstWhere('slug', 'pink-marble-ceramic-mug')?->id,
                'status' => ReviewStatus::Approved->value,
            ],
            [
                'customer_name' => 'هدى جلال',
                'rating' => 4,
                'comment' => 'صندوق عيد الميلاد أسعد صديقتي جداً، التنسيق جميل والعلبة فخمة.',
                'gift_box_id' => $createdBoxes->skip(1)->first()?->id,
                'status' => ReviewStatus::Approved->value,
            ],
        ];

        foreach ($reviewsData as $rev) {
            Review::create($rev);
        }

        // 10. Company Inquiries (استفسارات الشركات)
        $inquiriesData = [
            [
                'company_name' => 'شركة النيل للحلول التكنولوجية',
                'contact_person' => 'م / أحمد فؤاد',
                'phone' => '01019998888',
                'email' => 'a.fouad@niletech.eg',
                'quantity' => 120,
                'budget' => 500.00,
                'message' => 'نود إعداد هدايا نهاية العام لجميع موظفي الشركة مع طباعة شعار الشركة على الصناديق والأكواب الحرارية.',
                'status' => InquiryStatus::InReview->value,
            ],
            [
                'company_name' => 'مجموعة الأمل الطبية',
                'contact_person' => 'د / ريهام حسني',
                'phone' => '01227776666',
                'email' => 'hr@alamal-group.com',
                'quantity' => 60,
                'budget' => 750.00,
                'message' => 'هدايا تكريم للأطباء واستشاريي المستشفى في المؤتمر السنوي القادم.',
                'status' => InquiryStatus::New->value,
            ],
            [
                'company_name' => 'وكالة إبداع للإعلان والتسويق',
                'contact_person' => 'طارق كمال',
                'phone' => '01115554444',
                'email' => 'tarek@ibdaa-agency.com',
                'quantity' => 35,
                'budget' => 900.00,
                'message' => 'هدايا لكبار العملاء VIP مع لمسات شخصية وفاخرة لكل عميل.',
                'status' => InquiryStatus::Quoted->value,
            ],
        ];

        foreach ($inquiriesData as $inq) {
            CompanyInquiry::updateOrCreate(['phone' => $inq['phone']], $inq);
        }
    }
}
