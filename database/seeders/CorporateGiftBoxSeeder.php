<?php

namespace Database\Seeders;

use App\Models\CorporateGiftBox;
use Illuminate\Database\Seeder;

class CorporateGiftBoxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $boxes = [
            [
                'name' => 'صندوق الترحيب بالموظف الجديد (Welcome Box)',
                'slug' => 'corporate-welcome-box',
                'description' => 'مخصص للموظف الجديد ليترك انطباعاً أولياً استثنائياً ويزيد من شعور الانتماء للمؤسسة من اليوم الأول.',
                'price' => 550.00,
                'min_quantity' => 10,
                'features' => [
                    'Notebook باسم وهوية الشركة',
                    'Premium Pen (قلم معدني فاخر)',
                    'Mug أو Tumbler حراري بشعار الشركة',
                    'ID / Badge Holder احترافي',
                    'Keychain ميدالية مفاتيح مخصصة',
                    'Welcome Card كارت ترحيبي شخصي',
                    'Stickers لاصقات بشعار الشركة',
                    'بوكس بتغليف وهوية الشركة المعتمدة',
                ],
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'صندوق شكر وتقدير الموظفين (Employee Appreciation Box)',
                'slug' => 'corporate-employee-appreciation-box',
                'description' => 'باقة راقية مخصصة للتعبير عن الامتنان والتقدير لجهود وتفاني الموظفين وفريق العمل.',
                'price' => 680.00,
                'min_quantity' => 10,
                'features' => [
                    'Premium Notebook دفتر فاخر',
                    'Premium Pen قلم أنيق',
                    'Tumbler مج حافظ للحرارة',
                    'Mini Candle شمعة معطرة طبيعية',
                    'Chocolate Box علبة شوكولاتة فاخرة',
                    'Appreciation Card كارت شكر وتقدير',
                    'Keychain ميدالية مفاتيح راقية',
                    'Gift Box بتغليف فاخر ومميز',
                ],
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'صندوق شكراً لك (Thank You Box)',
                'slug' => 'corporate-thank-you-box',
                'description' => 'هدية شكر بسيطة وأنيقة للموظفين، العملاء، والمتعاونين تعبر عن خالص الامتنان بلمسة راقية.',
                'price' => 420.00,
                'min_quantity' => 15,
                'features' => [
                    'Mug مج سيراميك أنيق مطبوع',
                    'Notebook دفتر ملاحظات عملي',
                    'Pen قلم أنيق',
                    'Chocolate تشكيلة شوكولاتة لذيذة',
                    'Thank You Card بطاقة شكر مخصصة',
                    'Keychain ميدالية مفاتيح مميزة',
                    'Custom Gift Box علبة هدايا مخصصة',
                ],
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'صندوق الإنجاز والتميز (Achievement Box)',
                'slug' => 'corporate-achievement-box',
                'description' => 'يُقدم عند تحقيق إنجاز استثنائي أو الوصول إلى التارجت (Target) للاحتفاء بالنجاح والتفوق.',
                'price' => 850.00,
                'min_quantity' => 5,
                'features' => [
                    'Premium Notebook دفتر ملاحظات فخم',
                    'Metal Pen قلم معدني محفور بالليزر',
                    'Tumbler مج حراري ستانلس ستيل',
                    'Mini Trophy / Achievement Plaque درع / مجسم إنجاز تذكاري',
                    'Chocolate شوكولاتة فاخرة',
                    'Congratulations Card بطاقة تهنئة بالإنجاز',
                    'Custom Packaging تغليف مخصص للاحتفال بالإنجاز',
                ],
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'صندوق الترقية والمناصب الجديدة (Promotion Box)',
                'slug' => 'corporate-promotion-box',
                'description' => 'مخصص للاحتفال بترقية الموظف وتوليه مهام ومسؤوليات جديدة بما يليق بمكانته الجديدة.',
                'price' => 950.00,
                'min_quantity' => 5,
                'features' => [
                    'Leather/PU Notebook أجندة جلدية راقية',
                    'Premium Metal Pen قلم تنفيذي معدني فاخر',
                    'Premium Tumbler مج حراري عالي الجودة',
                    'Business Card Holder حامل بطاقات عمل أنيق',
                    'Chocolate شوكولاتة بلجيكية فاخرة',
                    '"Congratulations on Your Promotion" Card كارت تهنئة بالترقية',
                    'Premium Gift Box صندوق هدايا تنفيذي فاخر',
                ],
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'صندوق موظف الشهر (Employee of the Month Box)',
                'slug' => 'corporate-employee-of-the-month-box',
                'description' => 'هدية شهرية تحفيزية لتكريم نجم الشهر وتقدير أدائه المتميز وإلهام بقية الفريق.',
                'price' => 720.00,
                'min_quantity' => 3,
                'features' => [
                    'Mini Trophy 🏆 مجسم كأس التميز الذهبي',
                    'Premium Mug / Tumbler مج حراري مميز',
                    'Notebook دفتر ملاحظات احترافي',
                    'Pen قلم أنيق',
                    'Certificate / Recognition Card شهادة تقدير معتمدة',
                    'Chocolate شوكولاتة احتفالية فاخرة',
                    'Employee of the Month Card بطاقة موظف الشهر',
                    'Branded Box صندوق مطبوع بشعار الشركة',
                ],
                'is_active' => true,
                'sort_order' => 6,
            ],
            [
                'name' => 'صندوق المولد النبوي الشريف (Moulid Box)',
                'slug' => 'corporate-moulid-box',
                'description' => 'هدية موسمية روحانية راقية لموظفي وشركاء الشركة بمناسبة المولد النبوي الشريف.',
                'price' => 490.00,
                'min_quantity' => 10,
                'features' => [
                    'سبحة كريستال / خشبية أنيقة',
                    'سجادة صلاة صغيرة فاخرة قابلة للطي',
                    'علبة تمر فاخر محشو ومغلف',
                    'حلويات شرقية متميزة منتقاة بعناية',
                    'كارت تهنئة بالمولد النبوي الشريف',
                    'فاصل كتاب إسلامي بتصميم راقي',
                    'تغليف بطابع المناسبة الإسلامية الشريفة',
                ],
                'is_active' => true,
                'sort_order' => 7,
            ],
            [
                'name' => 'صندوق رمضان كريم (Ramadan Kareem Box)',
                'slug' => 'corporate-ramadan-kareem-box',
                'description' => 'أجواء رمضانية مميزة لفريق العمل والعملاء تعبر عن أصالة وضيافة الشهر الفضيل.',
                'price' => 590.00,
                'min_quantity' => 15,
                'features' => [
                    'فانوس رمضان صغير بإضاءة دافئة',
                    'تمر فاخر عالي الجودة',
                    'مج حراري أو Mug بتصميم رمضاني',
                    'سبحة أنيقة',
                    'Chocolate تشكيلة شوكولاتة رمضانية',
                    'كارت رمضان كريم مخصص للمؤسسة',
                    'Ramadan Decoration زينة رمضانية أنيقة',
                    'Gift Box رمضاني بتصميم مستوحى من التراث',
                ],
                'is_active' => true,
                'sort_order' => 8,
            ],
            [
                'name' => 'صندوق عيد مبارك (Eid Mubarak Box)',
                'slug' => 'corporate-eid-mubarak-box',
                'description' => 'هدية العيد الاحتفالية لإدخال البهجة والسرور على الموظفين وشركاء النجاح.',
                'price' => 520.00,
                'min_quantity' => 15,
                'features' => [
                    'تمر فاخر منتقى بعناية',
                    'كحك وبسكويت العيد الفاخر بالسمن البلدي',
                    'Chocolate تشكيلة شوكولاتة العيد اللذيذة',
                    'Mug أو Tumbler أنيق',
                    'Eid Greeting Card كارت تهنئة بالعيد السعيد',
                    'Eid Decoration لمسات وزينة احتفالية للعيد',
                    'Gift Bag / Box علبة هدايا العيد المبهجة',
                ],
                'is_active' => true,
                'sort_order' => 9,
            ],
            [
                'name' => 'صندوق وجبة إفطار رمضان (Ramadan Iftar Box)',
                'slug' => 'corporate-ramadan-iftar-box',
                'description' => 'بوكس إفطار متكامل (Food-Oriented) مخصص للفعاليات الرمضانية وإفطار الشركات وتوزيعات الخير.',
                'price' => 240.00,
                'min_quantity' => 30,
                'features' => [
                    'تمر سكري / مجدول مغلف فردياً',
                    'زجاجة مياه معدنية نقية',
                    'عصير طبيعي منعش (قمر الدين / تمر هندي / برتقال)',
                    'سناك ومكسرات مشكلة فاخرة',
                    'Chocolate سناك شوكولاتة للتحلية',
                    'سبحة صغيرة أنيقة',
                    'كارت Ramadan Kareem مخصص بشعار الشركة',
                    'Packaging صحي وعملي مناسب للإفطار والتنقل',
                ],
                'is_active' => true,
                'sort_order' => 10,
            ],
        ];

        foreach ($boxes as $box) {
            CorporateGiftBox::updateOrCreate(
                ['slug' => $box['slug']],
                $box
            );
        }
    }
}
