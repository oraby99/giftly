<?php

use App\Enums\InquiryStatus;
use App\Enums\ReviewStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('gift_box_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('order_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('order_item_id')->nullable()->constrained('order_items')->nullOnDelete();
            $table->string('review_token')->unique()->nullable();
            $table->unsignedTinyInteger('rating');
            $table->text('comment')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('status')->default(ReviewStatus::Pending->value)->index();
            $table->timestamps();

            $table->unique(['order_item_id', 'review_token'], 'reviews_order_item_token_unique');
        });

        Schema::create('company_inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('contact_person');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->unsignedInteger('quantity');
            $table->decimal('budget', 10, 2)->nullable();
            $table->text('message')->nullable();
            $table->string('status')->default(InquiryStatus::New->value)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('company_inquiries');
        Schema::dropIfExists('reviews');
    }
};
