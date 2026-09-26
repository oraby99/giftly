<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gift_boxes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->boolean('is_featured')->default(false)->index();
            $table->unsignedSmallInteger('sort_order')->default(0)->index();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('gift_box_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gift_box_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->unsignedSmallInteger('quantity')->default(1);
            $table->timestamps();

            $table->unique(['gift_box_id', 'product_id']);
        });

        Schema::create('gift_box_occasion', function (Blueprint $table) {
            $table->foreignId('gift_box_id')->constrained()->cascadeOnDelete();
            $table->foreignId('occasion_id')->constrained()->cascadeOnDelete();
            $table->primary(['gift_box_id', 'occasion_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gift_box_occasion');
        Schema::dropIfExists('gift_box_items');
        Schema::dropIfExists('gift_boxes');
    }
};
