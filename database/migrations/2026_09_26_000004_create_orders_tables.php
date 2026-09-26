<?php

use App\Enums\OrderStatus;
use App\Enums\OrderType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->string('customer_name')->nullable();
            $table->string('customer_phone')->nullable()->index();
            $table->text('customer_address')->nullable();
            $table->string('status')->default(OrderStatus::Pending->value)->index();
            $table->decimal('subtotal', 10, 2);
            $table->decimal('packaging_cost', 10, 2)->default(0);
            $table->decimal('delivery_cost', 10, 2)->nullable();
            $table->decimal('total', 10, 2);
            $table->text('customer_notes')->nullable();
            $table->string('order_type')->default(OrderType::ReadyMade->value);
            $table->timestamp('whatsapp_opened_at')->nullable();
            $table->timestamps();

            $table->index('created_at');
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->string('item_type');
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('gift_box_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name_snapshot');
            $table->unsignedSmallInteger('quantity');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('total_price', 10, 2);
            $table->json('customization_data')->nullable();
            $table->timestamps();

            $table->index('order_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};
