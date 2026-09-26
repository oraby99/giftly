<?php

use App\Enums\OrderStatus;
use App\Models\Category;
use App\Models\PackagingOption;
use App\Models\Product;

test('custom box builder page can be rendered', function () {
    $response = $this->get('/custom-box-builder');
    $response->assertStatus(200);
});

test('cart and corporate pages can be rendered', function () {
    $this->get('/cart')->assertStatus(200);
    $this->get('/corporate')->assertStatus(200);
    $this->get('/about')->assertStatus(200);
    $this->get('/contact')->assertStatus(200);
    $this->get('/favorites')->assertStatus(200);
});

test('customer can place order and get whatsapp redirect and pending status', function () {
    $category = Category::create([
        'name' => 'شوكولاتة',
        'slug' => 'chocolates',
        'is_active' => true,
        'sort_order' => 1,
    ]);

    $product = Product::create([
        'name' => 'علبة شوكولاتة بلجيكية فاخرة',
        'slug' => 'luxury-belgian-chocolate',
        'description' => 'شوكولاتة داكنة وحليب فاخرة',
        'price' => 250.00,
        'category_id' => $category->id,
        'is_active' => true,
        'stock_quantity' => 20,
    ]);

    $packaging = PackagingOption::create([
        'name' => 'صندوق خشبي فاخر مع شريط ساتان',
        'description' => 'صندوق خشبي محفور يدوياً',
        'price' => 90.00,
        'is_active' => true,
        'sort_order' => 1,
    ]);

    $payload = [
        'customer_name' => 'أحمد محمد',
        'customer_phone' => '01012345678',
        'customer_address' => 'القاهرة، المعادي، شارع 9',
        'customer_notes' => 'يرجى التوصيل بعد الساعة 5 مساءً',
        'items' => [
            [
                'type' => 'product',
                'product_id' => $product->id,
                'quantity' => 1,
            ],
            [
                'type' => 'custom_gift_box',
                'quantity' => 1,
                'packaging_option_id' => $packaging->id,
                'occasion' => 'عيد ميلاد',
                'recipient_type' => 'صديق',
                'personal_message' => 'كل عام وأنت بألف خير وسعادة يا صديقي!',
                'products' => [
                    [
                        'product_id' => $product->id,
                        'quantity' => 2,
                    ],
                ],
            ],
        ],
    ];

    $response = $this->postJson(route('orders.store'), $payload);

    $response->assertStatus(200);
    $response->assertJsonStructure([
        'order_number',
        'total',
        'whatsapp_url',
        'confirmation_url',
    ]);

    $orderNumber = $response->json('order_number');

    $this->assertDatabaseHas('orders', [
        'order_number' => $orderNumber,
        'customer_name' => 'أحمد محمد',
        'customer_phone' => '01012345678',
        'status' => OrderStatus::Pending->value,
    ]);

    $confirmResponse = $this->get(route('orders.confirmation', $orderNumber));
    $confirmResponse->assertStatus(200);
    $confirmResponse->assertSee($orderNumber);
});

test('company inquiry can be submitted', function () {
    $payload = [
        'company_name' => 'شركة التقنية الحديثة',
        'contact_person' => 'م / سارة محمود',
        'phone' => '01098765432',
        'email' => 'sara@moderntech.com',
        'quantity' => 50,
        'budget' => 600,
        'message' => 'طلب عرض أسعار لهدايا المؤتمر السنوي',
    ];

    $response = $this->post(route('corporate.inquiry.store'), $payload);

    $response->assertSessionHas('success');
    $this->assertDatabaseHas('company_inquiries', [
        'company_name' => 'شركة التقنية الحديثة',
        'contact_person' => 'م / سارة محمود',
        'quantity' => 50,
    ]);
});
