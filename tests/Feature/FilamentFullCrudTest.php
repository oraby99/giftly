<?php

use App\Enums\InquiryStatus;
use App\Enums\OrderStatus;
use App\Enums\OrderType;
use App\Enums\ReviewStatus;
use App\Filament\Resources\Categories\CategoryResource;
use App\Filament\Resources\CompanyInquiries\CompanyInquiryResource;
use App\Filament\Resources\GiftBoxes\GiftBoxResource;
use App\Filament\Resources\Occasions\OccasionResource;
use App\Filament\Resources\Orders\OrderResource;
use App\Filament\Resources\PackagingOptions\PackagingOptionResource;
use App\Filament\Resources\Products\ProductResource;
use App\Filament\Resources\Reviews\ReviewResource;
use App\Models\Category;
use App\Models\CompanyInquiry;
use App\Models\GiftBox;
use App\Models\Occasion;
use App\Models\Order;
use App\Models\PackagingOption;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;

beforeEach(function () {
    $this->admin = User::first() ?? User::factory()->create([
        'name' => 'Admin User',
        'email' => 'admin@giftly.eg',
    ]);
});

test('admin can access all resource list pages', function () {
    $resources = [
        CategoryResource::class,
        ProductResource::class,
        GiftBoxResource::class,
        OccasionResource::class,
        PackagingOptionResource::class,
        OrderResource::class,
        ReviewResource::class,
        CompanyInquiryResource::class,
    ];

    foreach ($resources as $resource) {
        $url = $resource::getUrl('index');
        $this->actingAs($this->admin)
            ->get($url)
            ->assertSuccessful();
    }
});

test('admin can access all resource create pages', function () {
    $resources = [
        CategoryResource::class,
        ProductResource::class,
        GiftBoxResource::class,
        OccasionResource::class,
        PackagingOptionResource::class,
        OrderResource::class,
        ReviewResource::class,
        CompanyInquiryResource::class,
    ];

    foreach ($resources as $resource) {
        $url = $resource::getUrl('create');
        $this->actingAs($this->admin)
            ->get($url)
            ->assertSuccessful();
    }
});

test('admin can access all resource edit pages', function () {
    $category = Category::first() ?? Category::create(['name' => 'Test Cat', 'slug' => 'test-cat']);
    $product = Product::first() ?? Product::create(['name' => 'Test Prod', 'slug' => 'test-prod', 'price' => 100, 'category_id' => $category->id]);
    $giftBox = GiftBox::first() ?? GiftBox::create(['name' => 'Test Box', 'slug' => 'test-box', 'price' => 200]);
    $occasion = Occasion::first() ?? Occasion::create(['name' => 'Test Occasion', 'slug' => 'test-occasion']);
    $packaging = PackagingOption::first() ?? PackagingOption::create(['name' => 'Test Pack', 'price' => 25]);
    $order = Order::first() ?? Order::create(['customer_name' => 'Test Customer', 'customer_phone' => '01000000000']);
    $review = Review::first() ?? Review::create(['customer_name' => 'Test Reviewer', 'rating' => 5, 'comment' => 'Great!']);
    $inquiry = CompanyInquiry::first() ?? CompanyInquiry::create(['company_name' => 'Test Co', 'contact_person' => 'Person', 'phone' => '01100000000', 'quantity' => 10]);

    $editTests = [
        [CategoryResource::class, $category],
        [ProductResource::class, $product],
        [GiftBoxResource::class, $giftBox],
        [OccasionResource::class, $occasion],
        [PackagingOptionResource::class, $packaging],
        [OrderResource::class, $order],
        [ReviewResource::class, $review],
        [CompanyInquiryResource::class, $inquiry],
    ];

    foreach ($editTests as [$resource, $record]) {
        $url = $resource::getUrl('edit', ['record' => $record]);
        $this->actingAs($this->admin)
            ->get($url)
            ->assertSuccessful();
    }
});

test('admin can access order view page', function () {
    $order = Order::first() ?? Order::create(['customer_name' => 'View Test', 'customer_phone' => '01200000000']);

    $url = OrderResource::getUrl('view', ['record' => $order]);
    $this->actingAs($this->admin)
        ->get($url)
        ->assertSuccessful();
});

test('complete CRUD lifecycle for Category', function () {
    $category = Category::create([
        'name' => 'تصنيف اختبار جديد',
        'slug' => 'crud-test-cat',
        'description' => 'وصف اختباري',
        'is_active' => true,
    ]);
    expect($category->exists)->toBeTrue();

    $category->update(['name' => 'تصنيف اختبار معدل']);
    expect($category->fresh()->name)->toBe('تصنيف اختبار معدل');

    $category->delete();
    expect(Category::find($category->id))->toBeNull();
});

test('complete CRUD lifecycle for Product', function () {
    $category = Category::first() ?? Category::create(['name' => 'Default Cat', 'slug' => 'def-cat-for-prod']);
    $product = Product::create([
        'category_id' => $category->id,
        'name' => 'منتج اختبار دورة الحياة',
        'slug' => 'crud-test-prod',
        'description' => 'وصف منتج اختباري',
        'price' => 150.00,
        'stock_quantity' => 50,
        'is_active' => true,
    ]);
    expect($product->exists)->toBeTrue();

    $product->update(['price' => 175.00]);
    expect($product->fresh()->price)->toBe('175.00');

    $product->delete();
    expect(Product::find($product->id))->toBeNull();
    expect(Product::withTrashed()->find($product->id))->not->toBeNull();
});

test('complete CRUD lifecycle for GiftBox', function () {
    $box = GiftBox::create([
        'name' => 'صندوق اختبار دورة الحياة',
        'slug' => 'crud-test-box',
        'description' => 'وصف صندوق اختباري',
        'price' => 450.00,
        'is_active' => true,
    ]);
    expect($box->exists)->toBeTrue();

    $box->update(['price' => 500.00]);
    expect($box->fresh()->price)->toBe('500.00');

    $box->delete();
    expect(GiftBox::find($box->id))->toBeNull();
    expect(GiftBox::withTrashed()->find($box->id))->not->toBeNull();
});

test('complete CRUD lifecycle for Order', function () {
    $order = Order::create([
        'customer_name' => 'عميل اختبار CRUD',
        'customer_phone' => '01011112222',
        'customer_address' => 'القاهرة، المعادي',
        'customer_notes' => 'ملاحظات خاصة',
        'status' => OrderStatus::Pending,
        'order_type' => OrderType::ReadyMade,
        'subtotal' => 200,
        'packaging_cost' => 50,
        'delivery_cost' => 30,
        'total' => 280,
    ]);
    expect($order->exists)->toBeTrue();
    expect($order->order_number)->not->toBeEmpty();

    $order->update(['status' => OrderStatus::Confirmed, 'delivery_cost' => 40]);
    expect($order->fresh()->status)->toBe(OrderStatus::Confirmed);

    $order->delete();
    expect(Order::find($order->id))->toBeNull();
});

test('complete CRUD lifecycle for Review', function () {
    $review = Review::create([
        'customer_name' => 'تقييم اختبار CRUD',
        'rating' => 5,
        'comment' => 'تجربة ممتازة جداً وخدمة راقية',
        'status' => ReviewStatus::Pending,
    ]);
    expect($review->exists)->toBeTrue();

    $review->update(['status' => ReviewStatus::Approved]);
    expect($review->fresh()->status)->toBe(ReviewStatus::Approved);

    $review->delete();
    expect(Review::find($review->id))->toBeNull();
});

test('complete CRUD lifecycle for CompanyInquiry', function () {
    $inquiry = CompanyInquiry::create([
        'company_name' => 'شركة الفا للبرمجيات',
        'contact_person' => 'محمد أحمد',
        'phone' => '01099887766',
        'email' => 'alpha@example.com',
        'quantity' => 150,
        'budget' => 25000,
        'status' => InquiryStatus::New,
    ]);
    expect($inquiry->exists)->toBeTrue();

    $inquiry->update(['status' => InquiryStatus::InReview]);
    expect($inquiry->fresh()->status)->toBe(InquiryStatus::InReview);

    $inquiry->delete();
    expect(CompanyInquiry::find($inquiry->id))->toBeNull();
});
